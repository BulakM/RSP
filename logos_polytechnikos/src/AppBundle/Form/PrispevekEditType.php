<?php

namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Stav;

class PrispevekEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
          ->add('stav', EntityType::class, array(
              'class' => Stav::class,
              'placeholder' => 'Vyberte stav',
          ));
    }
}
