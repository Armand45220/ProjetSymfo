<?php

namespace App\Form;

use App\Entity\Action;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionModifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_act', HiddenType::class, [
                'label' => 'Nom de l\'action',
                'attr' => [
                    'placeholder' => "Nom de l'action",
                ],
                'required' => false,
            ])
            ->add('desc_act', HiddenType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => "Description de l'action",
                ],
                'required' => false,
            ])
            ->add('Modifier', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Action::class,
        ]);
    }
}
