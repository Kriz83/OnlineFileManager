<?php

namespace AppBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddUserDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $groupsNames = $options['data']['groupsNames'];
        
        $builder
        ->add('name' , TextType::class, array(
            'attr' => array(
                'class' => 'form-control' , 
                'style' => '
                    color:black; font-size:12px; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px;
                '),
            'label' => 'Imię :',
            'required' => true,	
		))		
		->add('surname' , TextType::class, array(
            'attr' => array(
                'class' => 'form-control' , 
                'style' => '
                    color:black; font-size:12px; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px;
                '),
            'label' => 'Nazwisko :',
            'required' => true,	
		))
		->add('email' , TextType::class, array(
            'attr' => array(
                'class' => 'form-control' , 
                'style' => '
                    color:black; font-size:12px; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px;
                '),
            'label' => 'Adres E-mail :',
            'required' => false,	
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
		));
		
    }
}
