<?php

namespace App\Form;


use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;



class ModifPermType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('type_offre', HiddenType::class, [
            'label' => 'Type d\'offre',
            'data' => 1,
            'attr' => [
                'value' => 1,
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

        ->add('date_debut_val', null, [
            'label' => 'Début validité',
            'attr' => [
            'id' => 'date_debut_val',
            'class' => 'classePerm'
            ]
            ])
        ->add('date_fin_val', null, [
            'label' => 'Fin validité',
            'attr' => [
            'id' => 'date_fin_val',
            'class' => 'classePerm'
            ]
            ])

        ->add('nb_places_min', null, [
            'label' => 'Places minimum',
            'attr' => [
            'id' => 'nb_places_min',
            'class' => 'classePerm'
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