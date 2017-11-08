<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Stav;

class CasopisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
          ->add('rok', DateType::class, array('widget' => 'choice'));
          ->add('cislo', IntegerType::class, array('label' => 'Číslo časopisu'))
          ->add('stav', EntityType::class, [
                'label' => 'Stav časopisu',
                'class' => Stav::class,
            ]);
    }
}
