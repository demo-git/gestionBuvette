<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\Facture;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantite', IntegerType::class, array(
                'label' => 'Quantité :',
                'attr' => array('min' => 1, 'class' => 'form-control'),
                'required' => true
            ))
            ->add('prix', IntegerType::class, array(
                'label' => 'Coût total :',
                'scale' => 2,
                'attr' => array('min' => 0, 'step' => 0.01, 'class' => 'form-control', 'placeholder' => '€'),
                'required' => true
            ))
            ->add('Ajouter', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-success btn-margin')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Facture::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'facture_add';
    }
}