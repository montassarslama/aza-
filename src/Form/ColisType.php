<?php

namespace App\Form;
use App\Entity\Colis;
use App\Entity\Colistype as EntityColistype;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
class ColisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'name',
                ]
            ])
            ->add('departure', TextType::class, [
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Adresse departure',
                    ]
                ]
            )
            ->add('destination', TextType::class, [
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Adresse destination',
                    ]
                ]
            )
            ->add('quantity', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Quantity',
                ]
            ])
            ->add('prix', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Prix',
                ]
            ])
            ->add('phone', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Phone',
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'email',
                ]])
            ->add('date', DateType::class, [
                'attr' => ['class' => 'form-control '],

                'widget' => 'single_text',

            ])
            ->add('image', FileType::class, array('data_class' => null, 'required' => false))
            ->add('colistype', EntityType::class, [
                'class' => EntityColistype::class,
                'attr' => ['class' => 'form-control'
                ]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Colis::class,
        ]);

    }
}