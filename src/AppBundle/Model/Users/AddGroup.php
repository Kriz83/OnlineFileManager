<?php

namespace AppBundle\Model\Users;

use AppBundle\Entity\GroupName;

/**
 * AddGroup
 */
class AddGroup
{
		
	/**
     * {@inheritdoc}
     */
    public function addGroup($em, $name)
    {
        //check if group name is not in db
        $groupData = $em->getRepository('AppBundle:GroupName')->findOneByName($name);

        if ($groupData != null) {
            return 1;
        }

        //set new GroupName
        $groupName = new GroupName;
								
		$groupName->setName($name);
										
		$em->persist($groupName);
		
		$em->flush();
		
		return null;
    }
				
}
