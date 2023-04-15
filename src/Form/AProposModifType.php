<?php

namespace App\Form;

use App\Entity\APropos;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AProposModifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descReglements', TextareaType::class,  [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => "Description des règlements",
                ],
                'required' => false
            ])
            ->add('email', TextareaType::class,  [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => "email de l'équipe",
                ],
                'required' => false
            ])
            ->add('modifier', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => APropos::class,
        ]);
    }
}
