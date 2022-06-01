<?php

namespace App\Form\Type;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nombre'])
            ->add('surnames', TextType::class, ['label' => 'Apellidos'])
            ->add('dni', TextType::class, ['label' => 'DNI'])
            ->add('birthDate', BirthdayType::class, ['placeholder' => 'Seleccione una opción'])
            ->add('phoneNumber', TextType::class, ['label' => 'Teléfono'])
            ->add('email', TextType::class, ['label' => 'Email'])
            ->add('diagnostic', TextareaType::class, ['label' => 'Diagnóstico'])
            ->add('caseHistory', TextareaType::class, ['label' => 'Historial Clínico'])
            ->add('save', SubmitType::class, ['label' => 'Aceptar'])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}