<?php
namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class OffreModifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('type_offre', ChoiceType::class, [
            'choices' => [
                'Offre permanente' => 1,
                'Offre limitée' => 2,
            ],
            'expanded' => true,
            'multiple' => false,
            'attr' => [
                'id' => 'type_offre',
                'data-target' => '#permanent'
            ]
        ])
        ->add('nom_offre')
        ->add('desc_offre')
        ->add('lien_offre')
        ->add('date_debut_val', null, [
            'attr' => [
            'class' => 'classePerm'
            ]
        ])
        ->add('date_fin_val', null, [
            'attr' => [
            'class' => 'classePerm'
            ]
        ])
        ->add('date_debut_aff', null, [
            'attr' => [
            'id' => 'date_debut_aff',
            'class' => 'classeLim'
            ]
            ])
        ->add('date_fin_aff', null, [
            'attr' => [
            'id' => 'date_fin_aff',
            'class' => 'classeLim'
            ]
            ])
        ->add('nb_places_min', null, [
            'attr' => [
            'class' => 'classePerm'
            ]
        ])
        ->add('num_aff', null, [
            'attr' => [
            'id' => 'num_aff',
            'class' => 'classeLim'

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