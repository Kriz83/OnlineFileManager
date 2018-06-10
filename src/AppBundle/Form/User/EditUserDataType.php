<?php

namespace AppBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EditUserDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $groupsNames = $options['data']['groupsNames'];
        $userData = $options['data']['userData'];

        $surnameData = $userData['surname'];
        $nameData = $userData['name'];
        $emailData = $userData['email'];
        $groupNameData = $userData['groupData'];
        
        $builder
        ->add('name' , TextType::class, array(
            'attr' => array(
                'class' => 'form-control' , 
                'style' => '
                    color:black; font-size:12px; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px;
                '),
            'label' => 'Imię :',
            'required' => true,	
            'data' => $nameData,	
		))		
		->add('surname' , TextType::class, array(
            'attr' => array(
                'class' => 'form-control' , 
                'style' => '
                    color:black; font-size:12px; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px;
                '),
            'label' => 'Nazwisko :',
            'required' => true,	
            'data' => $surnameData,
		))
		->add('email' , TextType::class, array(
            'attr' => array(
                'class' => 'form-control' , 
                'style' => '
                    color:black; font-size:12px; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px;
                '),
            'label' => 'Adres E-mail :',
            'required' => false,	
            'data' => $emailData,
		))
		->add('groupName' , ChoiceType::class, array(
            'choices' => array(
                $groupsNames,
            ),
            'attr' => array(
                'class' => 'form-control' ,
                'style' => 'color:black; font-size:12px; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px'
            ),
            'label' => 'Grupa :',
            'required' => false,	
            'data' => $groupNameData,		
		));
		
    }
}
