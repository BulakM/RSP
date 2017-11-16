<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Stav;

class RecenzeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
          ->add('text', TextAreaType::class, ['label' => 'Zadejte recenzi', 'attr' => ['rows' => 5], 'required' => false])
          ->add('odbornost', ChoiceType::class, array(
              'choices'  => range(1,5),
              'choice_label' => function ($choice) {
                return $choice;
              },
            ))
          ->add('zajimavost', ChoiceType::class, array(
              'choices'  => range(1,5),
              'choice_label' => function ($choice) {
                return $choice;
              },
            ))
          ->add('aktualnost', ChoiceType::class, array(
              'choices'  => range(1,5),
              'choice_label' => function ($choice) {
                return $choice;
              },
            ));
    }
}
