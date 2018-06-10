<?php

namespace AppBundle\Model\Catalogues;

/**
 * ChangeCatalogueName
 */
class ChangeCatalogueName
{
	    
	/**
     * {@inheritdoc}
     */
    public function changeCatalogueName($em, $catalogueObject, $currentCatalogueName, $form, $pathData)
    {
        
        $newCatalogueName = $form['name']->getData();
        $groupName = $form['groupName']->getData();

        //change name in Db
        $catalogueObject->setName($newCatalogueName);
        $catalogueObject->setGroupName($groupName);
                                
        $em->persist($catalogueObject);
        $em->flush();
        
		return null;
		
    }
	
}
