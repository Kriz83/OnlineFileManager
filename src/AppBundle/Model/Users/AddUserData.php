<?php

namespace AppBundle\Model\Users;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\User;
use AppBundle\Entity\UserData;

use AppBundle\Model\MailTo;

/**
 * AddUserData
 */
class AddUserData
{
	
	/**
     * {@inheritdoc}
     */
    public function setNewUserData($em, $form)
    {
        $name = $form['name']->getData();
        $surname = $form['surname']->getData();
        $group = $form['groupName']->getData();
        $email = $form['email']->getData();
        //check if user with email is not in db
        $userData = $em->getRepository('AppBundle:User')->findOneByEmailData($email);
        
        if ($userData != null) {
            return 2;
        }

        $groupName = $em->getRepository('AppBundle:GroupName')->findOneById($group);

	    //validate email	
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) && $email != '') {			
			return 1;			
		}
        //set new User
        $user = new User;
						
		$user->setUsername($email);
		$user->setEmail($email);
        
        //change if we want to add own pass for new 
        $randomNumber = rand(11,99);
        $nameData = ucwords($name);
        $surnameData = $surname[0];
        $pass = '!'.$nameData.$surnameData.$randomNumber;
        
		$user->setPlainPassword($pass);
		$user->setRoles(['ROLE_USER']);
		$user->setEnabled(1);
			
        $em->persist($user);        
        $em->flush();
        
        //set userData	        
		$userData = new UserData;
						
		$userData->setName($name);
		$userData->setSurname($surname);
		$userData->setUserId($user);
		$userData->setGroupName($groupName);
										
        $em->persist($userData); 		
        $em->flush();
        
        //set user data in User      
        $user->setGroupData($userData);

        $em->persist($user);  	
        $em->flush();

        //send email to user
        $sendEmail = new MailTo;
        $sendEmail = $sendEmail->mailTo($email, $pass); 
		
		return null;
    }
				
}
