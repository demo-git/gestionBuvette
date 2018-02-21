<?php

namespace UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use UserBundle\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class,array(
                'choices'  => array('Boisson' => Produit::TYPE_DRINK, 'Sandwitch' => Produit::TYPE_SANDWITCH, 'Snack' => Produit::TYPE_SNACK, 'Pizza' => Produit::TYPE_PIZZA),
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                'attr' => array('class' => 'selectpicker', 'title' => 'Type de produit')
            ))
            ->add('isBillable', ChoiceType::class,array(
                'choices'  => array('Facturable' => true, 'Non facturable' => false),
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                'attr' => array('class' => 'selectpicker', 'title' => 'Type d\'ajout')
            ))
            ->add('nom', TextType::class, array(
                'label' => 'Nom :',
                'attr' => array('class' => 'form-control')
            ))
            ->add('prixVente', NumberType::class, array(
                'label' => 'Prix de vente :',
                'scale' => 2,
                'attr' => array('min' => 0, 'class' => 'form-control', 'placeholder' => '€'),
                'required' => false
            ))
            ->add('cuisson', IntegerType::class, array(
                'label' => 'Temps de cuisson (minutes) :',
                'attr' => array('min' => 0, 'class' => 'form-control'),
                'required' => false
            ))
            ->add('warnThreshold', IntegerType::class, array(
                'label' => 'Seuil d\'alerte warning :',
                'attr' => array('min' => -1, 'class' => 'form-control'),
                'required' => true
            ))
            ->add('dangerThreshold', IntegerType::class, array(
                'label' => 'Seuil d\'alerte danger :',
                'attr' => array('min' => -1, 'class' => 'form-control'),
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
            'data_class' => Produit::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'produit_modifier';
    }
}