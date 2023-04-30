<?php
namespace App\Form;

use App\Entity\FichierOffre;
use App\Entity\Fichier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class FoAjoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('fichiers', FileType::class, [
            'label' => 'Fichier (PDF, JPG, PNG)',
            'mapped' => false,
            'required' => true,
            'multiple' => true,
            'constraints' => [
                new Assert\Count([
                    'min' => 1,
                    'max' => 3,
                    'minMessage' => 'Veuillez sélectionner au moins une image.',
                    'maxMessage' => 'Vous ne pouvez sélectionner que jusqu\'à 3 images.'
                ]),
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
        ]);
    }
}