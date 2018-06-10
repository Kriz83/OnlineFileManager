<?php

namespace AppBundle\Model\Documents;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Liip\ImagineBundle\Model\Binary;

/**
 * UploadFile
 */
class UploadFile
{
    /**
     * {@inheritdoc}
     */
    public function uploadFile($em, $file, $directory, $catalogueId)
    {
        if (is_object($file)) {

            $fileExtension = $file->guessExtension();
            $fileName = $file->getClientOriginalName();
            //check if in directory file with name do not exist            
            $dbFileName = substr($fileName, 0, strpos($fileName, '.'.$fileExtension));

            if ($catalogueId != null) {
                $fileExist = $em
                    ->getRepository('AppBundle:Document')
                    ->getFileByCatalogueAndFilename($dbFileName, $fileExtension, $catalogueId);
            } else {
                $fileExist = $em
                    ->getRepository('AppBundle:Document')
                    ->getFileByNullCatalogueAndFilename($dbFileName, $fileExtension);
            }

            //return $directory;
            if ($fileExist == null) {

                //check if file have correct extension
                if (!($fileExtension == 'jpeg' || $fileExtension == 'jpg' || $fileExtension == 'png' || $fileExtension == 'pdf')) {                
                // return 1;                
                }
                
                if(filesize($file) == false || filesize($file) >= 5242880) {              
                    return 2;                
                }

                //add files to server            
                $file->move($directory, $fileName);

            } else {
                return 3;
            }
                        
        }

        $data = [];
        $data['fileName'] = $fileName;
        $data['directory'] = $directory;
        $data['fileExtension'] = $fileExtension;

        return $data;

    }

}