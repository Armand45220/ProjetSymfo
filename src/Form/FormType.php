<?php

namespace App\Form;
use App\Entity\MessUtilisateur;
use App\Entity\Contact;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_cont',TextType::class,[
                'label'    => 'Nom',
                'required' => true,
                'attr' => ['style' => 'width: 30em;'],
            
            ])
            ->add('prenom_cont',TextType::class,[
                'label'    => 'Prénom',
                'required' => true,
                'attr' => ['style' => 'width: 30em;']
            ])
            ->add('email_cont',EmailType::class,[
                'label'    => 'Adresse mail',
                'required' => true,
                'attr' => ['style' => 'width: 30em;']
            ])
            ->add('libelle_mess',TextareaType::class,[
                'label'    => 'Message',
                'required' => true,
                'attr' => ['style' => 'width: 30em;']
            ])
            ->add('inscription_cont', CheckboxType::class, [
                'label'    => 'Inscrire à la newsletter',
                'required' => false,
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'contact',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

        ]);
    }
}
