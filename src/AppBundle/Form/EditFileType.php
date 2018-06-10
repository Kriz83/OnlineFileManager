<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use AppBundle\Entity\Document;

class EditFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'fileName', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; font-size:12px; width:250px; height:80px'),
                    'required' => true,
                    'label' => 'Nazwa pliku',
                )
            )
            ->add(
                'description', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; font-size:12px; width:350px; height:90px'),
                    'required' => false,
                    'label' => 'Opis pliku',
            )
        );
		
    }
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Document::class,
        ));
    }
	
}
