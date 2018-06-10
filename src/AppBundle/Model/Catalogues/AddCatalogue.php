<?php

namespace AppBundle\Model\Catalogues;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;


use AppBundle\Model\AddDocuments\UploadImage;
use AppBundle\Entity\Catalogue;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * AddCatalogue
 */
class AddCatalogue
{
	    
	/**
     * {@inheritdoc}
     */
    public function addCatalogue($em, $catalogueObject, $catalogueName, $groupName, $catalogueId, $directory)
    {
        
        //add catalogue data to db
        $catalogueObject->setName($catalogueName);
        $catalogueObject->setParent($catalogueId);
        $catalogueObject->setGroupName($groupName);
                                
        $em->persist($catalogueObject);
        $em->flush();

        if (!is_dir($directory.$catalogueObject->getId())) {
            //make new directory on Server
            mkdir($directory.$catalogueObject->getId(), 0755, true); 
        }
        
		return null;
		
    }

	/**
     * unused feature
     * 
     * {@inheritdoc}
     */
    public function removeCatalogue($catalogue)
    {

        unlink("$catalogue");
        		
		return 1;
		
	}

	
}
