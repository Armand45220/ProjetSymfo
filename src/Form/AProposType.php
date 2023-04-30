<?php

namespace App\Form;

use App\Entity\APropos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AProposType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descReglements', HiddenType::class,  [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => "Description des règlements",
                ],
                'required' => false
            ])
            ->add('email', HiddenType::class,  [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => "Email de l'équipe",
                ],
                'required' => false
            ])
            ->add('Ajouter', SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => APropos::class,
        ]);

    }
}
