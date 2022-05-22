<?php

namespace App\Form\Type;

use App\Entity\AssociatedTest;
use App\Entity\Test;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssociatedTestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('test', EntityType::class, array(
                'class' => Test::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t');
                }
            ))
            ->add('save', SubmitType::class, ['label' => 'Aceptar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AssociatedTest::class,
        ]);
    }
}