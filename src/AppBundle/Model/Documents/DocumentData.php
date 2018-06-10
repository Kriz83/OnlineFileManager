<?php

namespace AppBundle\Model\Documents;

use AppBundle\Model\Documents\UploadFile;
use AppBundle\Entity\Document;
use AppBundle\Entity\Catalogue;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * DocumentData
 */
class DocumentData
{ 
	
	/**
     * {@inheritdoc}
     */
    public function addDocument($em, $form, $directory, $catalogueId)
    {
        $uploadFile = new UploadFile();        
        						
        //upload passport
        $file = $form['newFile']->getData();  
        $upload = null;
        
        if (is_object($file)) {     
            $upload = $uploadFile->uploadFile($em, $file, $directory, $catalogueId);
        }
            
        return $upload;
    }

	/**
     * {@inheritdoc}
     */
    public function addFile($em, $addFiles, $fileDescription, $catalogueData)
    {

        $fileName = $addFiles['fileName'];
        $directory = $addFiles['directory'];
        $fileExtension = $addFiles['fileExtension'];
        //get filename without extension
        $fileName = substr($fileName, 0, strpos($fileName, '.'.$fileExtension));
        //set main direcory as 0
                
        $document = new Document;
    
        $document->setFilename($fileName);
        $document->setDescription($fileDescription);
        $document->setCatalogs($catalogueData);
        $document->setFileExtension($fileExtension);
                                
        $em->persist($document);
        $em->flush();
        		
		return null;
		
	}

	/**
     * {@inheritdoc}
     */
    public function removeFile($em, $directory, $fileName, $extension)
    { 
        
        //set main path
        $path =  getcwd().'/documents/';
        
        //get current catalogue data
        $catalogueData = $em
            ->getRepository('AppBundle:Catalogue')
            ->findOneByIdData($directory); 

        //set data depends if catalogue exist (no data == main Catalogue)
        if ($catalogueData != null) {
            //get catalogue data
            $parent = $catalogueData['parent'];
                    
            //set catalogues data by find all by parent       
            if ($parent != 0 && $parent != null) {
                
                while ($catalogueData != null) {
                   //set catalogue data to array
                    $pathData[] = $catalogueData['id'];
                    //get catalogue data by parent
                    $catalogueData = $em
                        ->getRepository('AppBundle:Catalogue')
                        ->findOneByParentId($parent); 
                    //break if there are no higher catalogues
                    if ($catalogueData == null) {
                        break;
                    }
                    //get catalogueData
                    $parent = $catalogueData['parent'];   

                }
                //reverse array becouse of finding from last catalogue to root
                $pathData = array_reverse($pathData, true);
                               
                foreach ($pathData as $key) {
                    //set path
                    $path .= '/'.$key;
                }

            } else {                          
                //get catalogue data       
                $path .= '/'.$directory;
            }
            
        }

        //create full file name with path 
        $filenameWithPath = $path.'/'.$fileName.'.'.$extension;

        //get file object and remove from db
        if ($directory != 0) {
            $file = $em
            ->getRepository('AppBundle:Document')
            ->getFileToRemove($fileName, $extension, $directory);  
        } else {
            $file = $em
                ->getRepository('AppBundle:Document')
                ->getFileToRemoveFromMain($fileName, $extension);
        }     
        
        $em->remove($file);
        $em->flush();

        //remove phisical file
        unlink("$filenameWithPath");
        		
		return null;
		
	}

	/**
     * {@inheritdoc}
     */
    public function editFile($em, $id, $fileName, $catalogueId, $extension, $newFilename, $fileDescription, $newFileDescription)
    {
              
        //set main path
        $path =  getcwd().'/documents/';
       
        if (($fileName != $newFilename) || ($fileDescription != $newFileDescription))  {
            //get catalogueId in db
            $catalogueData = $em
                ->getRepository('AppBundle:Catalogue')
                ->findOneByIdData($catalogueId);
            
           //set data depends if catalogue exist (no data == main Catalogue)
            if ($catalogueData != null) {
                //get catalogue data
                $parent = $catalogueData['parent'];
                        
                //set catalogues data by find all by parent       
                if ($parent != 0 && $parent != null) {
                    
                    while ($catalogueData != null) {
                    //set catalogue data to array
                        $pathData[] = $catalogueData['id'];
                        //get catalogue data by parent
                        $catalogueData = $em
                            ->getRepository('AppBundle:Catalogue')
                            ->findOneByParentId($parent); 
                        //break if there are no higher catalogues
                        if ($catalogueData == null) {
                            break;
                        }
                        //get catalogueData
                        $parent = $catalogueData['parent'];   

                    }
                    //reverse array becouse of finding from last catalogue to root
                    $pathData = array_reverse($pathData, true);
                                
                    foreach ($pathData as $key) {
                        //set path
                        $path .= '/'.$key;
                    }

                } else {                          
                    //get catalogue data       
                    $path .= '/'.$catalogueId;
                }
                
            }
            
            
            //create full file name with path 
            $filenameWithPath = $path.'/'.$fileName.'.'.$extension;
            
            $newFilenameWithPath = $path.'/'.$newFilename.'.'.$extension;
           
            //get file object and remove from db
            $file = $em
                ->getRepository('AppBundle:Document')
                ->findOneById($id);

            $file->setFileName($newFilename);
            $file->setDescription($newFileDescription);

            $em->persist($file);
            $em->flush();

            //remove phisical file
            rename ("$filenameWithPath", "$newFilenameWithPath");
        }
        
		return null;
		
	}

	/**
     * {@inheritdoc}
     */
    public function downloadFileContent($em, $catalogueId, $filename)
    {
          
        //set main path
        $path =  getcwd().'/documents/';
        
        //get catalogue data
        $catalogueData = $em
            ->getRepository('AppBundle:Catalogue')
            ->findOneByIdData($catalogueId); 

        //get path
        $pathData = [];
        $pathData[$catalogueData['id']] = $catalogueData['name'];        
        $parent = $catalogueData['parent'];
        $catName = $catalogueData['name'];
                
        //get parent and current catalogue 
        if ($catalogueId != 0) {
            if ($parent != 0 && $parent != null) {
            
                while ($catalogueData != null) {
                    
                    $pathData[$catalogueData['id']] = $catName;
    
                    $catalogueData = $em
                        ->getRepository('AppBundle:Catalogue')
                        ->findOneByParentId($parent); 
    
                    if ($catalogueData == null) {
                        break;
                    }
                    
                    $parent = $catalogueData['parent'];    
                    $catName = $catalogueData['name'];   
    
                }
    
                $pathData = array_reverse($pathData, true);
                
                foreach ($pathData as $key => $value) {
                    $path .= '/'.$key;
                }
    
            } else {                                  
                $path .= '/'.$catalogueId;
            }
        }       
        
        
        $pathData = realpath($path);

        //get file content
        $content = file_get_contents($path.'/'.$filename);
        		
		return $content;
		
    }
    
	/**
     * {@inheritdoc}
     */
    public function getFiles($em, $catalogueId)
    {
        if ($catalogueId != 0) {
            $files = $em
                ->getRepository('AppBundle:Document')
                ->getFilesByCatalogue($catalogueId); 
        } else {
            $files = $em
                ->getRepository('AppBundle:Document')
                ->getFilesByNullCatalogue(); 
        }

        return $files;

    }
	
}
