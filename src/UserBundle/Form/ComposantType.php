<?php

namespace UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComposantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produitComposant', EntityType::class, array(
                'class' => 'CuisineBundle:Produit',
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
            'data_class' => 'CuisineBundle\Entity\Composant',
        ));
    }

    public function getBlockPrefix()
    {
        return 'composant_add';
    }
}