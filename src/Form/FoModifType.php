<?php

namespace App\Form;

use App\Entity\FichierOffre;
use App\Entity\Fichier; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;


class FoModifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fichier', FileType::class, [
            'label' => 'Fichier',
            'required' => true,
            'mapped' => false,
            'constraints' => [
                new Assert\All([
                    'constraints' => [
                        new Assert\File([
                            'mimeTypes' => [
                                'image/png',
                                'image/jpg',
                                'image/jpeg',
                                'application/pdf',
                            ],
                            'mimeTypesMessage' => 'Les fichiers doivent être au format PNG, JPG, JPEG ou PDF.',
                        ]),
                    ],
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FichierOffre::class,
            'fichier' => null,
        ]);
    }
}