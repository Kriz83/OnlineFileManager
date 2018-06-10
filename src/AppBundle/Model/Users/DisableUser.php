<?php

namespace AppBundle\Model\Users;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;

/**
 * DisableUser
 */
class DisableUser
{
	
	/**
     * {@inheritdoc}
     */
    public function disableUser($em, $userId)
    {
        //get user
        $user = $em->getRepository('AppBundle:User')->findOneById($userId);
						
		$user->setEnabled(0);
			
        $em->persist($user);        
        $em->flush();        
		
		return null;
    }
				
}
