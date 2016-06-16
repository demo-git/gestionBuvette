<?php

namespace UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use UserBundle\Entity\Image;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('path', FileType::class, array(
                'label' => 'Image :',
                'required' => false,
                'attr' => array('class' => 'file','data-preview-file-type' => "image")
            ))
            ->add('Enregistrer', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-success btn-margin')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Image::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'image';
    }
}