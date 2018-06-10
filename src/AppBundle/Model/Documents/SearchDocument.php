<?php

namespace AppBundle\Model\Documents;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * SearchDocument
 */
class SearchDocument
{
	    
	/**
     * {@inheritdoc}
     */
    public function searchFiles($em,$search, $userGroupId)
    {
        $files = null;

        //if user is not admin
        
        if ($userGroupId != null && $userGroupId != 0) {
            $catalogueList = $em
            ->getRepository('AppBundle:Catalogue')
            ->findByPrivliges($userGroupId);
            
            
            $files = $em
                ->getRepository('AppBundle:Document')
                ->findByFileNameAndCatalogueList($search, $catalogueList); 
        } else {
            
            $files = $em
                ->getRepository('AppBundle:Document')
                ->findByFileName($search);  

        }

        return $files;

    }
	
}
