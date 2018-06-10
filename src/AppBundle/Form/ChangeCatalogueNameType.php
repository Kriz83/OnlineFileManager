<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ChangeCatalogueNameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $groupNames = $options['data']['groupNames'];
        $catalogue = $options['data']['catalogue'];

        $groupNameData = $catalogue->getGroupName();

        $builder
            ->add('name', TextType::class, array(
            'attr' => array(
				'class' => 'form-control' ,
                'style' => '
                        margin-bottom:15px; 
                        width:333px; 
                        height:40px; 
                        font-size:13px; 
                        font-weight: 700; 
                        color: black; 
                        position: relative;
                        border: 0px; display: inline-block;
                        '),
				'label' => 'Nazwa Folderu:',
                'required' => false,
                'data' => $catalogue->getName(),
		))
		->add('groupName' , ChoiceType::class, array(
            'choices' => $groupNames,
            'multiple' => true,
            'attr' => array(
                'class' => 'form-control' ,
                    'style' => 'color:black; font-size:14px; margin-bottom:15px; border: 1px solid darkgreen; width:333px; height:297px'
                ),
            'label' => 'Grupa uprawniona:',
            'required' => false,
            'data' => $groupNameData,				
		));
		
    }
	
}
