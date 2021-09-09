<?php

namespace App\Form;

use App\Data\SearchFilter;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
   {
      $builder
            ->add('city', TextType::class, [
               'label' => false,
               'required' => false,
               'attr' => [
                  'placeholder' => 'Annecy'
               ]
            ])
            ->add('zipCode', TextType::class, [
               'label' => false,
               'required' => false,
               'attr' => [
                  'placeholder' => '74000'
               ]
            ])
            ->add('service', EntityType::class, [
               'label' => false,
               'required' => false,
               'class' => Service::class,
               'expanded' => true,
               'multiple' => true,
            ]);
   }
   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchFilter::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
       return '';
    }
}