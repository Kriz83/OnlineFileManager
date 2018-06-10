<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Model\Documents\SearchDocument;
use AppBundle\Model\Catalogues\GetCatalogueList;

class SearchController extends Controller
{
    
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/searchedDocuments/{searchData}", name="searchedDocuments")
     */
    public function searchedDocumentsAction(Request $request, $searchData = null)
    {
        //get manager     
        $container = $this->container;
        
        $userGroupData = $this->get('security.token_storage')->getToken()->getUser();
        
        $userGroupId = $userGroupData->getGroupData();
        if ($userGroupId != null) {
            $userGroupId = $userGroupId->getGroupName();
            if ($userGroupId != null) {
                $userGroupId = $userGroupId->getId();
            }
        }

        //search data when redirected from search
        if ($searchData == null) {
            //get search from request
            $search = $request->request->get('search');
        } else {
            $search = $searchData;
        }
        
        //get list of catalogues depend on user roles
        $user = $this->get('security.token_storage')->getToken()->getUser()->getRoles();
        $userRoles = $user[0];

        //get data from models
        $searchDocument = new SearchDocument($container);
        //search files
        $files = $searchDocument->searchFiles($this->em, $search, $userGroupId);  

        //get data from models
        $getCatalogueList = new GetCatalogueList();

        $catalogueList = $getCatalogueList->getCatalogueList($this->em, $userGroupData, $userRoles, 0);
        //set parents data to get subfolders of current folders list
        $parentsData = [];
        $x = 0;

        foreach ($catalogueList as $list) {
            $subcatalogue = $list['id'];
            $parentsData[$x] = $subcatalogue;
            $x++;
        }

        //get list of subcatalogues depend on user roles        
        $subcatalogueList = $getCatalogueList->getSubcatalogueList($this->em, $userGroupData, $userRoles, $parentsData);
                        
        return $this->render('docs/documents/searchedDocuments.html.twig', array(
            'files' => $files,      
            'parentData' => null,
            'catalogueId' => 0,
            'catalogueList' => $catalogueList,
            'subcatalogueList' => $subcatalogueList,  
            'searchData' => $search,        
        ));
        
    } 
    
    /**
     * Unused feature
     * 
     * @Route("/removeFileFromSearch/{path}/{filename}/{extension}/{searchData}", name="removeFileFromSearch")
     */
    public function removeFileFromSearchAction(Request $request, $directory, $filename, $extension, $searchData)
    {

        $documentData = new DocumentData();
        //remove file
        $removeFile = $documentData->removeFile($this->em, $directory, $filename, $extension);
                        
        return $this->redirectToRoute('searchedDocuments', array(
            'searchData' => $searchData,
        ));
        
    }
    
}
