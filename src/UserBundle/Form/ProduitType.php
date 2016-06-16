<?php

namespace UserBundle\Form;

use UserBundle\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                'choices'  => array('Boisson' => Produit::TYPE_DRINK, 'Sandwitch' => Produit::TYPE_SANDWITCH, 'Snack' => Produit::TYPE_SNACK, 'Pizza' => Produit::TYPE_PIZZA, 'Composant' => Produit::TYPE_COMPOSANT),
                'expanded' => false,
                'multiple' => false,
                'attr' => array('class' => 'selectpicker', 'title' => 'Type de produit')
            ))
            ->add('nom', TextType::class, array(
                'label' => 'Nom :',
                'attr' => array('class' => 'form-control')
            ))
            ->add('prixVente', IntegerType::class, array(
                'label' => 'Prix de vente :',
                'scale' => 2,
                'attr' => array('min' => 0, 'step' => 0.01, 'class' => 'form-control', 'placeholder' => '€'),
                'required' => false
            ))
            ->add('cuisson', IntegerType::class, array(
                'label' => 'Temps de cuisson :',
                'attr' => array('min' => 0, 'class' => 'form-control', 'placeholder' => 'En minutes'),
                'required' => false
            ))
            ->add('composants', CollectionType::class, array(
                'allow_delete' => true,
                'allow_add' => true,
                'entry_type' => ComposantType::class
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