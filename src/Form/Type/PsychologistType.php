<?php

namespace App\Form\Type;

use App\Entity\Psychologist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PsychologistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nombre'])
            ->add('surnames', TextType::class, ['label' => 'Apellidos'])
            ->add('phoneNumber', TextType::class, ['label' => 'Teléfono'])
            ->add('email', TextType::class, ['label' => 'Email'])
            ->add('password', TextType::class, ['label' => 'Contraseña'])
            ->add('education', TextType::class, ['label' => 'Estudios Universitarios'])
            ->add('specialization', TextType::class, ['label' => 'Especialización'])
            ->add('collegiateNumber', TextType::class, ['label' => 'Número de Colegiado/a']) 
            ->add('save', SubmitType::class, ['label' => 'Aceptar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Psychologist::class,
        ]);
    }
}