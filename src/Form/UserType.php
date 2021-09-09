<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER',
                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add('city')
            ->add('zipCode', TextType::class)
            ->add('picture', FileType::class, [
                'label'=> 'Téléchargez un Avatar',
                'mapped' =>false,
                'required'=>false, 
                'constraints' => [
                    new File([
                        'maxSize' => '3000k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide',
                    ])
                ]
                ])
            ->add('phoneNumber')
            ->add('status')
            ->add('services', EntityType::class, [
                'by_reference' => false,
                'class' => Service::class,
                'required'=>false,
                'multiple' => true,
                'expanded' =>true,
                'attr' => ['size' => 10]
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

                $form = $event->getForm();
                $userData = $event->getData();

                if ($userData->getId() === null) {
                    // if we are in a creation mode password will be required
                    $required = true;
                    $form->add('password', PasswordType::class, [
                        'mapped' => false,
                        'required' => $required
                    ]);
                } else {
                    // if we are in an update mode don't need password
                    $required = false;
                }

                
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
