<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;





class ModifLimType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('type_offre', HiddenType::class, [
            'label' => 'Type d\'offre',
            'data' => 2,
            'attr' => [
                'value' => 2,
            ],
        ])
        ->add('nom_offre', null,[
            'label' => 'Nom',
        ])
        ->add('desc_offre', null, [
            'label' => 'Description',
        ])
        ->add('lien_offre', UrlType::class, [
            'label' => 'Lien',
        ])

        ->add('date_debut_aff', null, [
            'label' => 'Début d\'affichage',
            'attr' => [
            'id' => 'date_debut_aff',
            'class' => 'classeLim'
            ]
            ])
        ->add('date_fin_aff', null, [
            'label' => 'Fin d\'affichage',
            'attr' => [
            'id' => 'date_fin_aff',
            'class' => 'classeLim'
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
                    'minMessage' => 'La valeur doit être comprise entre 0 et 10',
                    'maxMessage' => 'La valeur doit être comprise entre 0 et 10.'
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
?>