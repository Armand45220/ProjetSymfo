<?php

namespace App\Form;


use App\Entity\Membre;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_membre', HiddenType::class,  [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => "Nom du membre",
                ],
            ])
            ->add('desc_membre', HiddenType::class,  [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => "Description du membre",
                ],
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => true,
            ])
            ->add('fichier_id', HiddenType::class, [
                'mapped' => false,
            ])
            ->add('Ajouter', SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}