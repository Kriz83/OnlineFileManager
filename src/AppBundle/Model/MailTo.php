<?php

namespace AppBundle\Model;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * MailTo
 */
class MailTo
{
	
	/**
     * {@inheritdoc}
     */
    public function mailTo($email, $pass)
    {
    	
        $content2 = '(BAZA DOKUMENTÓW SQS) - Założono nowe konto - twój adres e-mail to login!
            <br>
            https://doc.sqs.pl
            <br>
            Hasło wygenerowane Automatycznie: " '.$pass.' " po zalogowaniu proszę zmienić hasło na własne!';
            
        // To send HTML mail, the Content-type header must be set
        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: Your name <'.$email.'>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n"; 	

        // Mail it
        mail($email.', ', 'Nowe konto w bazie Dokumentów', $content2, $headers);
            		
		return null;
    }
				
}
