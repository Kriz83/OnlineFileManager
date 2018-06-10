<?php

namespace AppBundle\Model\Users;

use AppBundle\Entity\GroupName;

/**
 * EditGroup
 */
class EditGroup
{
		
	/**
     * {@inheritdoc}
     */
    public function editGroup($em, $groupName, $currentGroupName, $groupData)
    {
        //check if group name is not in db

        if ($groupName != $currentGroupName) {
            $groupNameCheck = $em->getRepository('AppBundle:GroupName')->findOneByName($groupName);

            if ($groupNameCheck != null) {
                return 1;
            }
        }
								
		$groupData->setName($groupName);
										
		$em->persist($groupData);
		
		$em->flush();
		
		return null;
    }
				
}
