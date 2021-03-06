<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Tema;

class CasopisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
          ->add('rok', ChoiceType::class, array(
            'choices' => range(date('Y') - 10, date('Y') + 4),
            'choice_label' => function ($choice) {
                return $choice;
              },
            'data' => ($builder->getData()->getId() != null) ? $builder->getData()->getRok() : date('Y')
            ))
          ->add('cislo', IntegerType::class, array('label' => 'Číslo časopisu', 'attr' => array('min' => 1)))
          ->add('casopis', FileType::class, array('label' => 'Časopis v pdf', 'required' => false, 'data_class' => null))
          ->add('temata', EntityType::class, array(
              'class' => Tema::class,
              'query_builder' => function (EntityRepository $er) {
                  return $er->createQueryBuilder('t')
                              ->where('t.aktivni = 1')
                              ->orderBy('t.nazev', 'ASC');
              },
              'empty_data' => null,
              'choice_label' => 'nazev',
              'required' => true,
              'placeholder' => 'Vyberte téma',
              'multiple' => true,
          ))
          ->add('uzaverka', DateTimeType::class, [
              'label' => 'Datum uzávěrky',
              'widget' => 'choice',
              'required' => false,
              'placeholder' => array('year' => 'Rok', 'month' => 'Měsíc', 'day' => 'Den', 'hour' => 'hodina', 'minute' => 'Minuta'),
              'data' => ($builder->getData()->getId() != null) ? $builder->getData()->getUzaverka() : new \DateTime('now')
            ]);
    }
}
