<?php

namespace AppBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name' , TextType::class, array(
				'attr' => array(
                    'class' => 'form-control' ,
                    'style' => '
                        color:black; font-size:12px; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px;
                    '),
				'label' => 'Nazwa Grupy :',
				'required' => true,	
		));
		
    }
}
