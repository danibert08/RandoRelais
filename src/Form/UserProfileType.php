<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\User;
use Doctrine\ORM\Query\Expr\From;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotNullValidator;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // We use the addEventlistener method on PPRE_SET_DATA to modify the form depending on the pre-populated data (adding or removing fields dynamically).
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData'])
            // We use the addEventlistener method on PRE_SUBMIT to add form fields, before submitting the data to the form.
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit'])
            ->add('currentStatus', CheckboxType::class, [
                'label'     => 'Ange du chemin',
                'disabled'  => true,
                'mapped' => false,
            ])
            ->add('status', HiddenType::class, [])
            ->add('picture', HiddenType::class, [])
            ->add('upload', FileType::class, [
                "mapped" => false,
                "required" => false,
                'label'         => 'Photo de profil',
                'label_attr'    => [
                    'class' => 'd-none'
                ],
                'attr'          => [
                    'class' => 'd-none'
                ],
                'data_class'    => null,
            ])
            ->add('firstName', null, [
                'label'         => "Prénom",
                'label_attr'    => [
                    'class' => "d-none"
                ],
                'attr'          => [
                    'disabled' => true,
                ],
                'empty_data' => ''
            ])
            ->add('lastName', null, [
                'label'         => "Nom",
                'label_attr'    => [
                    'class' => "d-none"
                ],
                'attr'          => [
                    'disabled' => true,
                ]
            ])
            ->add('email', null, [
                'label'         => "Adresse email",
                'label_attr'    => [
                    'class' => "d-none"
                ],
                'attr'          => [
                    'disabled' => true,
                ]
            ])
            // ! START DON'T TOUCH.
            // TODO START : not working so we comment the field UserProfileForm.plainPassword in the templates\user\profil.html.twig.
            // ->add('plainPassword', PasswordType::class, [
            //     // Instead of being set onto the object directly, this is read and encoded in the UserController.
            //     'mapped'        => false,
            //     'required'      => false,
            //     'label'         => "Mot de passe",
            //     'label_attr'    => [
            //         'class' => "d-none"
            //     ],
            //     'attr'          => [
            //         'autocomplete'  => 'new-password',
            //         'placeholder'   => 'Mot de passe'
            //     ],
            // ])
            // TODO END.
            // ! END.
            ->add('phoneNumber', TelType::class, [
                'required'      => false,
                'label'         => "Numéro de téléphone",
                'label_attr'    => [
                    'class' => "d-none"
                ],
                'attr'          => [
                    'disabled' => true,
                ]
            ])
            ->add('zipCode', TextType::class, [
                'required'      => false,
                'label'         => "Code postale",
                'label_attr'    => [
                    'class' => "d-none"
                ],
                'attr'          => [
                    'disabled' => true,
                ]
            ])
            ->add('city', null, [
                'required'      => false,
                'label'         => "Numéro de téléphone",
                'label_attr'    => [
                    'class' => "d-none"
                ],
                'attr'          => [
                    'disabled' => true,
                ]
            ])
            ->add('services', EntityType::class, [
                'required'      =>  false,
                'label'         => false,
                // 'label_attr'    => [
                //     'class' => "d-none"
                // ],
                'class'         => Service::class,
                'by_reference'  => false,
                'multiple'      => true,
                'expanded'      => true,
                'disabled' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    /**
     * Method who modify the form depending on the pre-populated data (adding or removing fields dynamically).
     *
     * @param FormEvent $event
     * @return void
     */
    public function onPreSetData(FormEvent $event)
    {
        // We get the form data.
        $user = $event->getData();
        $form = $event->getForm();

        // If the user's status is User::HIKER_STATUS.
        if ($user->getStatus() === User::HIKER_STATUS) {
            // We uncheck the checkbox.
            $switchValue = false;
            // We set the label's value.
            $label = "Modifier et cocher pour devenir Ange";
        } // Else if, the user's status is User::ANGEL_STATUS.
        elseif ($user->getStatus() === User::ANGEL_STATUS) {
            // We check the checkbox.
            $switchValue = true;
            // We set the label's value.
            $label = "Modifier et décocher pour redevenir Marcheur";
        }

        // We dynamically check or uncheck the switch according to the user's staus.
        $form
            ->add('currentStatus', CheckboxType::class, [
            'label'     => $label,
            'data'      => $switchValue,
            'mapped'    => false,
            'disabled'  => true
        ]);

        
        // TODO START : not working so we comment the field UserProfileForm.plainPassword in the templates\user\profil.html.twig.
        // // If we have a user in the databse.
        // if ($user->getId()) {
        //     // dd($user);
        //     // We don't required the password field.
        //     // We dont allow the password modification because, for is own security, the user must use the forget resset password feature.
        //     $required = false;
        // } // Else, we should not drop here but just in case.
        // else {
        //     // We stop the execution of the condition.
        //     exit();
        // }
        // // We dynamically add the password field.
        // $form
        //     ->add('plainPassword', PasswordType::class, [
        //         // Instead of being set onto the object directly, this is read and encoded in the UserController.
        //         'mapped'        => false,
        //         'required'      => $required,
        //         'label'         => "Mot de passe",
        //         'label_attr'    => [
        //             'class' => "d-none"
        //         ],
        //         'attr'          => [
        //             'autocomplete'  => 'new-password',
        //             'placeholder'   => 'Mot de passe'
        //         ],
        //         'constraints' => [
        //             new NotBlank([
        //                 'message' => 'Merci de saisir un mot de passe.'
        //             ]),
        //             new Length([
        //                 'min'        => 6,
        //                 'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} characteres.',
        //                 // max length allowed by Symfony for security reasons
        //                 'max'        => 4096,
        //             ])
        //         ],
        //     ]);
        // TODO END.
    }

    /**
     * Method wo display the form fields required for the angel registration if ($user['status']) === true / if the switch is checked
     *
     * @param FormEvent $event
     * @return void
    */
    public function onPreSubmit(FormEvent $event)
    {
        
        // We get the form data.
        $user = $event->getData();
        $form = $event->getForm();

        
        // We check if the switch button is checked.
        // If the status is different than null it's a User::ANGEL_STATUS else it's a User::HIKER_STATUS.
        $user['status']  = isset($user['currentStatus']) ? User::ANGEL_STATUS : User::HIKER_STATUS;

        // In order to collect the data related to the User::ANGEL_STATUS we need to require the form fields related to this status.
        if (isset($user['currentStatus']) && ($user['currentStatus'])) {
            // We add the form fields related to the User::ANGEL_STATUS with the attribute required => true.
            $form
                ->add('phoneNumber', null, [
                    'required'      => true,
                    'label'         => "Numéro de téléphone",
                    'label_attr'    => [
                        'class' => "d-none"
                    ],
                    'attr'          => [
                        'placeholder' => 'Numéro de téléphone'
                    ],
                    'constraints'   => [
                        new NotBlank([
                            'message' => 'Merci de saisir votre numéro de téléphone.'
                        ]),
                    ]
                ])
                ->add('zipCode', null, [
                    'required'      => true,
                    'label'         => "Code postale",
                    'label_attr'    => [
                        'class' => "d-none"
                    ],
                    'attr'          => [
                        'placeholder' => 'Code postale'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de saisir votre code postale.'
                        ])
                    ]
                ])
                ->add('city', null, [
                    'required'      => true,
                    'label'         => "Numéro de téléphone",
                    'label_attr'    => [
                        'class' => "d-none"
                    ],
                    'attr'          => [
                        'placeholder' => 'Commune'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de saisir le nom de votre commune.'
                        ])
                    ]
                ])
                ->add('services', EntityType::class, [
                    'required'      => true,
                    'label'         => false,
                    // 'label_attr'    => [
                    //     'class' => "d-none"
                    // ],
                    'class'         => Service::class,
                    'by_reference'  => false,
                    'multiple'      => true,
                    'expanded'      => true,
                    'constraints'   => [
                        new Count([
                            'min' => 1,
                            'minMessage' => 'Merci de sélectionner au minimum un {{ limit }} service.'
                        ]),
                    ],
                ]);
        }
        
        // We set the data of the event to the user.
        $event->setData($user);
    }
}
