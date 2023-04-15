<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints as Assert;


class OffrelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder        
        ->add('type_offre', HiddenType::class, [
            'label' => 'Type d\'offre',
            'data' => 2,
            'attr' => [
                'value' => 2,
            ],
        ])

        ->add('date_insert_offre', DateType::class, [
            'label' => 'Date Insertion',
            'format' => 'd-M-y',
            'data' => new \DateTime('now'),
            'disabled' => true
        ])

        ->add('nom_offre', null, [
            'label' => 'Nom',
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Ce champ ne peut pas être vide.'
                ])
                ],
            'attr' => [
                'placeholder' => "nom de l'offre",
                'class' => 'oFlex'
            ],
        ])

        ->add('desc_offre', null, [
            'label' => 'Description',
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Ce champ ne peut pas être vide.'
                ])
                ],
            'attr' => [
                'placeholder' => "description de l'offre",
                'class' => 'oFlex'
            ],
        ])

        ->add('Lien_offre', null, [
            'label' => 'Lien',
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Ce champ ne peut pas être vide.'
                ])
                ],
            'attr' => [
                'placeholder' => "lien de l'offre",
                'class' => 'oFlex'
            ],
        ])

        ->add('date_debut_aff', null, [
            'label' => 'Début Affichage',
            'placeholder' => [
                'year' => 'Année',
                'month' => 'Mois',
                'day' => 'Jour',
                'hour' => 'Heure',
                'minute' => 'Minute',
            ],
            'attr' => [
            'id' => 'date_debut_aff',
            'class' => 'classeLim , dateFlex'
            ]
            ])

        ->add('date_fin_aff', null, [
            'label' => 'Fin Affichage',
            'placeholder' => [
                'year' => 'Année',
                'month' => 'Mois',
                'day' => 'Jour',
                'hour' => 'Heure',
                'minute' => 'Minute',
            ],
            'attr' => [
            'id' => 'date_fin_aff',
            'class' => 'classeLim , dateFlex'
            ]
            ])

        ->add('num_aff', null, [
            'label' => 'Numéro Affichage',
            'attr' => [
                'id' => 'num_aff',
                'class' => 'classeLim , oFlex',
                'placeholder' => "numéro d'affichage (0-10)"
            ],
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Ce champ ne peut pas être vide.'
                ]),
                new Assert\Range([
                    'min' => 0,
                    'max' => 10,
                    'minMessage' => 'La valeur doit être supérieure ou égale à 0.',
                    'maxMessage' => 'La valeur doit être inférieure ou égale à 10.'
                ])
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}

