<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use AppBundle\Entity\FileToUpload;

class FileUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newFile', FileType::class, array(
            'attr' => array(
				'class' => 'form-control' ,
                'style' => '
                            width:250px; 
                            height:80px; 
                            font-size:12px; 
                            font-weight: 700; 
                            color: white; 
                            background-color: #006658; 
                            '),
				'required' => true,
                'label' => 'Nazwa pliku',
		))
        ->add(
            'description', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'color:black; font-size:12px; width:250px; height:85px'),
                'required' => false,
                'label' => 'Opis pliku',
            )
        );
		
    }
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => FileToUpload::class,
        ));
    }
	
}
