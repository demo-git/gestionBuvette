<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\Setting;

class SettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('warningWait', IntegerType::class, array(
                'label' => 'Temps d\'attente à partir duquel se déclenche les "warnings" (minutes) :',
                'attr' => array('min' => 0, 'class' => 'form-control'),
                'required' => true
            ))
            ->add('dangerWait', IntegerType::class, array(
                'label' => 'Temps d\'attente à partir duquel se déclenche les "dangers" (minutes) :',
                'attr' => array('min' => 0, 'class' => 'form-control'),
                'required' => true
            ))
            ->add('hovenCapacity', IntegerType::class, array(
                'label' => 'Nombre de place dans le(s) four(s) :',
                'attr' => array('min' => 0, 'class' => 'form-control'),
                'required' => true
            ))
            ->add('sauce', TextType::class, array(
                'label' => 'Les sauces disponibles (séparé par un ";") :',
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('Modifier', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-success btn-margin')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Setting::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'settings';
    }
}