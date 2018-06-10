<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Criteria;

use AppBundle\Model\Documents\DocumentData;
use AppBundle\Model\Catalogues\AddCatalogue;
use AppBundle\Model\Catalogues\SetPaths;
use AppBundle\Model\Catalogues\GetCatalogueList;
use AppBundle\Model\Catalogues\ChangeCatalogueName;

use AppBundle\Form\FileUploadType;
use AppBundle\Form\AddCatalogueType;
use AppBundle\Form\EditFileType;
use AppBundle\Form\ChangeCatalogueNameType;

use AppBundle\Entity\Catalogue;
use AppBundle\Entity\Document;

class DocumentsController extends Controller
{
    
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/addDocuments/{catalogueId}", name="addDocuments")
     */
    public function addDocumentsAction(Request $request, $catalogueId = 0)
    {
        //set no errors
        $errors = [];        
        $error = null;

        //get data from models
        $documentData = new DocumentData();

        //get user Roles to view only folders with concrete privliges
        $userGroupData = $this->get('security.token_storage')->getToken()->getUser();
        $userRoles = $this->get('security.token_storage')->getToken()->getUser()->getRoles();
        //set catalogue paths to view catalogues and files list for current path
        $setPaths = new SetPaths(); 
        $pathsData = $setPaths->setPaths($this->em, $catalogueId);
        
        $directory = $pathsData['directory'];
        $catalogueData = $pathsData['catalogueData'];
        $parentData = $pathsData['parentData'];
        $currentCatalogueName = $pathsData['currentCatalogueName'];
        $pathNameShow = $pathsData['pathNameShow'];
        $groupId = $pathsData['groupId'];    
       
        //check if user have privliges to open catalogue (prevent from writing own id in route)
        $goodToGo = 0;
        if ($groupId != null) {
            $userGroup = $userGroupData->getGroupData();
            if ($userGroup != null) {
                $userGroup = $userGroup->getGroupName();
                if ($userGroup != null) {
                    $userGroup = $userGroup->getId();
                    
                    foreach ($groupId as $gId) {
                        if ($gId == $userGroup || $gId == 0) {
                            $goodToGo = 1;
                            break;
                        }
                    }
                    if ($goodToGo === 0) {
                        $this->addFlash(
                            'error',
                            'Nie masz dostępu do tego katalogu!'
                        );
                        
                        return $this->redirectToRoute('addDocuments', array(
                            'catalogueId' => 0,
                            'error' => $error,
                            'errors' => $errors,
                        )); 
                    }
                }    
            }      
                   
        }

        //get files from current directory    
        $files = $documentData->getFiles($this->em, $catalogueId);          
        //get list of catalogues depend on user roles        
        $userRoles = $userRoles[0];
        
        //get catalogues list to view in left bar depend on user roles  
        $getCatalogueList = new GetCatalogueList();
        $catalogueList = $getCatalogueList->getCatalogueList($this->em, $userGroupData, $userRoles, $catalogueId);
        
        //set parents data to get subfolders of current folders list
        $parentsData = [];
        $x = 0;

        foreach ($catalogueList as $list) {
            $subcatalogue = $list['id'];
            $parentsData[$x] = $subcatalogue;
            $x++;
        }                   
       
        //get list of subcatalogues depend on user roles and catalogues id's 
        $subcatalogueList = $getCatalogueList->getSubcatalogueList($this->em, $userGroupData, $userRoles, $parentsData);

        //get current catalogue
        $catalogueData = $this->em
            ->getRepository('AppBundle:Catalogue')
            ->findOneById($catalogueId); 
        //
       
        //add file to server - get forms to add file and add Catalogue
        $form = $this->createForm(FileUploadType::class);        
        $form->handleRequest($request);

        //get group names for form choice (to add folder for selected groups of users)
        $groupNames = $this->em->getRepository('AppBundle:GroupName')->findAllData();
        
        $data = [];
        $data['groupNames'] = $groupNames;

        $catalogueObject = new Catalogue;
        
        $form2 = $this->get('form.factory')->createNamedBuilder('form', AddCatalogueType::class, $data)
            ->getForm();    

        $form2->handleRequest($request);
        //validate data
        $validator = $this->get('validator');

        //if file was send   
        if ($form->isSubmitted() && $form->isValid()) {
            //check and add file
            $addFile = $documentData->addDocument($this->em, $form, $directory, $catalogueId);
            
            if ($addFile == 2) {
               $this->addFlash(
                    'error',
                    'Nieprawidłowy rozmiar pliku - zmień rozmiar pliku poniżej 5 MB i dodaj ponownie!'
                );                                 
            } elseif ($addFile == 1) {                
                $this->addFlash(
                    'error',
                    'Nieprawidłowy typ pliku - dodaj zdjęcie (jpg, jpeg)!'
                );
            }  elseif ($addFile == 3) {
                $this->addFlash(
                    'error',
                    'Plik o tej nazwie już istnieje w tym katalogu!'
                );    
            } else {
                //add file record to db                
                $fileDescription = $form['description']->getData(); 
                $addFile = $documentData->addFile($this->em, $addFile, $fileDescription, $catalogueData);
            }
            
            return $this->redirectToRoute('addDocuments', array(
                'catalogueId' => $catalogueId,
                'error' => $error,
                'errors' => $errors,
            ));            
            
        }

        //add new catalogue
        if ($form2->isSubmitted()) {
            //validate
            $errors = $validator->validate($catalogueObject);
            //try to add folder only when validation passed
            if (count($errors) == 0) {
            
                $catalogueName = $form2['name']->getData();
                $groupName = $form2['groupName']->getData();
                
                //check if catalogue and catalogueId name are not in db
                $catalogueInDb = $this->em->getRepository('AppBundle:Catalogue')->findOneByName($catalogueName, $catalogueId);

                if ($catalogueInDb != null) {           
                    $this->addFlash(
                        'error',
                        'Folder o tej nazwie już istnieje!'
                    );
                } else {
                    //add new catalogue record to db
                    $catalogue = new AddCatalogue();
                    $addCatalogue = $catalogue->addCatalogue($this->em, $catalogueObject, $catalogueName, $groupName, $catalogueId, $directory);                   
                }
                
                return $this->redirectToRoute('addDocuments', array(
                    'catalogueId' => $catalogueId,
                    'errors' => $errors,
                ));
            }

        }

        return $this->render('docs/documents/addDocuments.html.twig', array(
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'files' => $files,
            'parentData' => $parentData,
            'catalogueId' => $catalogueId,
            'catalogueList' => $catalogueList,
            'subcatalogueList' => $subcatalogueList,
            'currentCatalogueName' => $currentCatalogueName, 
            'pathNameShow' => $pathNameShow,   
            'errors' => $errors,      
        ));
        
    } 
    
    
    /**
     * @Route("/download/{catalogueId}/{filename}")
     */
    public function downloadAction(Request $request, $catalogueId, $filename)
    {    
        //download document
        $addDocument = new DocumentData();

        $content = $addDocument->downloadFileContent($this->em, $catalogueId, $filename);
    
        $response = new Response();

        //set headers
        $response->headers->set('Content-Type', 'mime/type');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);

        $response->setContent($content);

        return $response;
    }
        
    /**
     * @Route("/editCatalogue/{id}", name="editCatalogue")
     */
    public function editCatalogueAction(Request $request, $id)
    {        
        $errors = [];
        //get catalogue data
        $catalogue = $this->em->getRepository('AppBundle:Catalogue')->findOneByIdDataObject($id);
        $currentCatalogueName = $catalogue->getName();
        $path = $catalogue->getPath();
        $catalogueId = $catalogue->getId();
        //get group names to choose right ones for edited folder
        $groupNames = $this->em->getRepository('AppBundle:GroupName')->findAllData();
        
        $data = [];
        $data['groupNames'] = $groupNames;
        $data['catalogue'] = $catalogue;

        //set form to change cataloguename or groupName
        $form = $this->createForm(ChangeCatalogueNameType::class, $catalogue, array(
            'data' => $data,
        ));
        $form->handleRequest($request);

        $validator = $this->get('validator');

        //if catalogue was send   
        if ($form->isSubmitted() && $form->isValid()) {
            
            $changeCatalogueName = new ChangeCatalogueName();
            //change catalogue data
            $editCatalogue = $changeCatalogueName->changeCatalogueName($this->em, $catalogue, $currentCatalogueName, $form, $path);
                            
            return $this->redirectToRoute('addDocuments', array(
                'catalogueId' => $catalogueId,
            ));
        }
        
        return $this->render('docs/catalogues/editCatalogue.html.twig', array(
            'form' => $form->createView(),
            'errors' => $errors,     
        ));

    }

    /**
     * @Route("/editFile/{id}", name="editFile")
     */
    public function editFileAction(Request $request, $id)
    {
        $errors = [];
        //get file data
        $file = $this->em->getRepository('AppBundle:Document')->findOneById($id);
        $fileName = $file->getFileName();
        $catalogueId = $file->getCatalogs();
        if ($catalogueId != null) {
            $catalogueId = $catalogueId->getId();
        }
        $extension = $file->getFileExtension();
        $description = $file->getDescription();
        
        //set form to change filename or description
        $form = $this->createForm(EditFileType::class, $file);
        $form->handleRequest($request);
        
        $validator = $this->get('validator');
        //if file was send   
        if ($form->isSubmitted() && $form->isValid()) {
            
            $newFilename = $form['fileName']->getData();
            $newFileDescription = $form['description']->getData();

            $documentData = new DocumentData();
            //change file's properties (file name in DB and phisycly and file description)
            $editFile = $documentData->editFile($this->em, $id, $fileName, $catalogueId, $extension, $newFilename, $description, $newFileDescription);
                       
            return $this->redirectToRoute('addDocuments', array(
                'catalogueId' => $catalogueId,
            ));
        }
        
        return $this->render('docs/documents/editDocuments.html.twig', array(
            'form' => $form->createView(),
            'errors' => $errors,     
        ));

    }
      
    /**
     * @Route("/removeFile/{path}/{fileName}/{extension}", name="removeFile")
     */
    public function removeFileAction(Request $request, $path, $fileName, $extension)
    {

        $documentData = new DocumentData();        
        //remove file from DB and Server
        $removeFile = $documentData->removeFile($this->em, $path, $fileName, $extension);
                   
        return $this->redirectToRoute('addDocuments', array(
            'catalogueId' => $path,
        ));
        
    }
    
}
