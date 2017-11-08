<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Stav;

class PrispevekType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
          ->add('text', TextAreaType::class, ['label' => 'Zadejte příspěvek', 'attr' => ['rows' => 5]])
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
