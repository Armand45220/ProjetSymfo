<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;

class OffrepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type_offre', ChoiceType::class, [
                'label' => 'Type',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.'
                    ])
                    ],
                'choices' => [
                    'Offre permanente' => 1,
                    'Offre limitée' => 2,
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => [
                    'id' => 'type_offre',
                    'data-target' => '#permanent',
                ],
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
            ->add('date_debut_val', null, [
                'label' => 'Début Validité',
                'placeholder' => [
                    'year' => 'Année',
                    'month' => 'Mois',
                    'day' => 'Jour',
                    'hour' => 'Heure',
                    'minute' => 'Minute',
                ],
                'attr' => [
                'class' => 'classePerm , dateFlex'
                ],
            ])
            ->add('date_fin_val', null, [
                'label' => 'Fin Validité',
                'placeholder' => [
                    'year' => 'Année',
                    'month' => 'Mois',
                    'day' => 'Jour',
                    'hour' => 'Heure',
                    'minute' => 'Minute',
                ],
                'attr' => [
                'class' => 'classePerm , dateFlex'
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
            ->add('nb_places_min', null, [
                'label' => 'Places Minimum',
                'attr' => [
                'class' => 'classePerm , oFlex',
                'placeholder' => "nombre de places minimum"
                ]
            ])
            ->add('num_aff', null, [
                'label' => 'Numéro Affichage',
                'attr' => [
                'id' => 'num_aff',
                'class' => 'classeLim , oFlex',
                'placeholder' => "numéro d'affichage"
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
