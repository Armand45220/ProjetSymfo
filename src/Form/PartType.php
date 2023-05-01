<?php
namespace App\Form;

use App\Entity\Partenaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_part', TextType::class,  [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => "Nom du partenaire",
                ],
            ])
            ->add('desc_part', TextareaType::class,  [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => "Description du partenaire",
                ],
            ])
            ->add('lien_part', UrlType::class, [
                'label' => 'Lien',
                'attr' => [
                    'placeholder' => "Lien du partenaire",
                ],
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier PDF, JPEG ou PNG valide',
                    ])
                ],
            ])
            ->add('fichier_id', HiddenType::class, [
                'mapped' => false,
            ])
            ->add('ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Partenaire::class,
        ]);
    }
}