<?php

namespace UserBundle\Form;

use CuisineBundle\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                'label' => 'Type :',
                'choices'  => array('Boisson' => Produit::TYPE_DRINK, 'Nourriture' => Produit::TYPE_FOOD, 'Snack' => Produit::TYPE_SNACK),
                'expanded' => false,
                'multiple' => false,
                'attr' => array('class' => 'form-control')
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
            ->add('pathImage', FileType::class, array(
                'label' => 'Image :',
                'required' => false,
                'attr' => array('class' => 'file','data-preview-file-type' => "image")
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
            'data_class' => 'CuisineBundle\Entity\Produit',
        ));
    }

    public function getBlockPrefix()
    {
        return 'produit_modifier';
    }
}