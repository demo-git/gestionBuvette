<?php

namespace UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\Composant;
use UserBundle\Entity\Produit;

class ComposantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produitComposant', EntityType::class, array(
                'class' => Produit::class,
                'choice_label' => 'nom',
                'label' => 'Produit :',
                'attr' => array('class' => 'selectpicker'),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')->where('c.actif = true');
                }
            ))
            ->add('quantite', NumberType::class, array(
                'label' => 'Quantité :',
                'scale' => 2,
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Composant::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'composant_add';
    }
}