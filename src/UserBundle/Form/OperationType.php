<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\Operation;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant', NumberType::class, array(
                'label' => 'Montant :',
                'scale' => 2,
                'attr' => array('min' => 0, 'class' => 'form-control', 'placeholder' => '€'),
                'required' => true
            ))
            ->add('type', ChoiceType::class,array(
                'choices'  => array('Retrait d\'argent' => Operation::TYPE_RETRAIT, 'Dépôt d\'argent' => Operation::TYPE_AJOUT),
                'expanded' => false,
                'multiple' => false,
                'attr' => array('class' => 'selectpicker', 'title' => 'Type de mouvement financier'),
                'required' => true
            ))
            ->add('justification', TextareaType::class, array(
                'label' => 'justification :',
                'attr' => array('class' => 'form-control'),
                'required' => true
            ))
            ->add('Enregistrer', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-success btn-margin')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Operation::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'operation';
    }
}