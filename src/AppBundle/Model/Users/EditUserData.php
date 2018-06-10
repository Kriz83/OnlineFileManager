<?php

namespace AppBundle\Model\Users;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\User;
use AppBundle\Entity\UserData;

use AppBundle\Model\MailTo;

/**
 * EditUserData
 */
class EditUserData
{
	
	/**
     * {@inheritdoc}
     */
    public function editUserData($em, $form, $userId)
    {
        //get edited user
        $user = $em->getRepository('AppBundle:User')->findOneById($userId);

        $emailData = $user->getEmail();

        $name = $form['name']->getData();
        $surname = $form['surname']->getData();
        $group = $form['groupName']->getData();
        $email = $form['email']->getData();
        //check if user with email is not in db
        $userEmailCheck = $em->getRepository('AppBundle:User')->findOneByEmailAndEmailData($email, $emailData);

        //set alert when email is in db allready and it isn't current user email
        if ($userEmailCheck != null) {
            return 2;     
        }

        $groupName = $em->getRepository('AppBundle:GroupName')->findOneById($group);

	    //validate email	
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) && $email != '') {			
			return 1;			
        }	

        //set UserData values	        
        $userData = $em->getRepository('AppBundle:UserData')->findOneByUserId($userId);

		$userData->setName($name);
		$userData->setSurname($surname);
		$userData->setGroupName($groupName);
										
        $em->persist($userData); 		
        $em->flush();
        
        //set User values						
		$user->setUsername($email);
		$user->setEmail($email);
        $user->setGroupData($userData);
			
        $em->persist($user);        
        $em->flush();
                
        		
		return null;
    }
	
			
}
