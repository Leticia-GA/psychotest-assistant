<?php

namespace App\Form\Type;

use App\Entity\AssociatedTest;
use App\Entity\Patient;
use App\Entity\Test;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssociatedTestToPatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('patient', EntityType::class, array(
                'label' => 'Paciente:',
                'class' => Patient::class,
                'query_builder' => function (EntityRepository $er) use($options){
                    return $er->createQueryBuilder('p')
                              ->andWhere("p.psychologist = :psychologist")
                              ->setParameters(["psychologist" => $options['psychologist']])
                    ;
                }
            ))
            ->add('save', SubmitType::class, ['label' => 'Aceptar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AssociatedTest::class,
            'psychologist' => null
        ]);
    }    
}