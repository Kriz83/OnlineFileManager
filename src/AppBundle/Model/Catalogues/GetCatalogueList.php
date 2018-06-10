<?php

namespace AppBundle\Model\Catalogues;

/**
 * GetCatalogueList
 */
class GetCatalogueList
{
	    
	/**
     * {@inheritdoc}
     */
    public function getCatalogueList($em, $userGroupData, $userRoles, $catalogueId)
    {
        //check catalogues privlige when user is logged
        if ($userRoles == 'ROLE_ADMIN') {
            //get all for ADMIN
            $catalogueList = $em->getRepository('AppBundle:Catalogue')
                ->findByParent($catalogueId);
                
        } elseif ($userRoles == 'ROLE_USER') {
            //get only those matches user privliges
            $privliges = $userGroupData->getGroupData()->getGroupName()->getId();
            
            $catalogueList = $em->getRepository('AppBundle:Catalogue')
                ->findByParentAndPrivliges($catalogueId, $privliges);
            //get catalogue list with null data (for all users) - null data == ALL
            $catalogueList2 = $em->getRepository('AppBundle:Catalogue')
                ->findByParentAndNullPriv($catalogueId);

            $catalogueList = array_merge($catalogueList, $catalogueList2);

        }        

		return $catalogueList;
		
    }
        
	/**
     * {@inheritdoc}
     */
    public function getSubcatalogueList($em, $userGroupData, $userRoles, $parentsData)
    {
        //check catalogues privlige when user is logged
        if ($userRoles == 'ROLE_ADMIN') {
            //get all for ADMIN
            $subcatalogueList = $em->getRepository('AppBundle:Catalogue')
                ->findByParents($parentsData);
        } elseif ($userRoles == 'ROLE_USER') {
            //get only those matches user privliges
            $privliges = $userGroupData->getId();
            
            $subcatalogueList = $em->getRepository('AppBundle:Catalogue')
                ->findByParentsAndPrivliges($parentsData, $privliges);
            //get catalogue list with null data (for all users) - null data == ALL
            $subcatalogueList2 = $em->getRepository('AppBundle:Catalogue')
                ->findByParentsAndNullPriv($parentsData);

            $subcatalogueList = array_merge($subcatalogueList, $subcatalogueList2);
        }

        return $subcatalogueList;
        
	}
		
}
