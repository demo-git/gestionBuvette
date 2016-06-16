<?php

namespace UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')->where('c.actif = true');
                }
            ))
            ->add('quantite', IntegerType::class, array(
                'label' => 'Quantité :',
                'attr' => array('min' => 1, 'class' => 'form-control'),
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