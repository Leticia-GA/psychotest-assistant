<?php

namespace App\Form\Type;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Test;
use App\Entity\TestDone;
use Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestDoneType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $testDone = $builder->getData();

        if(!$testDone instanceof TestDone) {
            throw new Exception("Invalid type");
        }

        $test = $testDone->getAssociatedTest()->getTest();
        $questions = $this->getQuestions($test);
        $choices = $this->getChoices($test);

        for($i = 0; $i < count($questions); $i++) {
            $question = $questions[$i];

            if (count($choices) > 0) {
                $builder->add(
                    'answer'.$i,
                    ChoiceType::class,
                    [
                        'label' => $question->getText(),
                        'choices' => $choices,
                        'multiple' => false,
                        'expanded' => true,
                        'mapped' => false
                    ]
                );
            }
        }
        
        $builder->add('save', SubmitType::class, ['label' => 'Enviar']);
    }

    private function getChoices(Test $test): array 
    {
        $answerRepository = $this->entityManager->getRepository(Answer::class);

        $answers = $answerRepository->findBy(
            ["test" => $test->getId()],
            ["position" => "ASC"]
        );

        $choices = [];

        foreach($answers as $answer) {
            $choices[$answer->getText()] = $answer->getScore();
        }

        return $choices;
    }

    private function getQuestions(Test $test): array 
    {
        $questionRepository = $this->entityManager->getRepository(Question::class);

        return $questionRepository->findBy(
            ["test" => $test->getId()],
            ["position" => "ASC"]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TestDone::class,
        ]);
    }
}