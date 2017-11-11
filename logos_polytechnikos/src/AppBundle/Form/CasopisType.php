<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Stav;

class CasopisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
          ->add('rok', ChoiceType::class, array('choices' => range(Date('Y') - 4, date('Y') + 4)))
          ->add('cislo', TextType::class, array('label' => 'Číslo časopisu'))
          ->add('stav', EntityType::class, [
                'label' => 'Stav časopisu',
                'class' => Stav::class,
            ])
          ->add('casopis', FileType::class, array('label' => 'Časopis v pdf'));
    }
}
