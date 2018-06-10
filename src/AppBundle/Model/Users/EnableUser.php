<?php

namespace AppBundle\Model\Users;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;

/**
 * EnableUser
 */
class EnableUser
{
	
	/**
     * {@inheritdoc}
     */
    public function enableUser($em, $userId)
    {
        //get user
        $user = $em->getRepository('AppBundle:User')->findOneById($userId);
						
		$user->setEnabled(1);
			
        $em->persist($user);        
        $em->flush();        
		
		return null;
    }
				
}
