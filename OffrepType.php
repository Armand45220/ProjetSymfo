<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints as Assert;

class OffrepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('type_offre', HiddenType::class, [
            'label' => 'Type d\'offre',
            'data' => 1,
            'attr' => [
                'value' => 1,
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
        ->add('nb_places_min', null, [
            'label' => 'Places Minimum',
            'attr' => [
            'class' => 'classePerm , oFlex',
            'placeholder' => "nombre de places minimum"
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
