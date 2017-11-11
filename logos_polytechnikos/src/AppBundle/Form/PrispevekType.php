<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Stav;
use AppBundle\Entity\Casopis;

class PrispevekType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
          ->add('nazev', TextType::class, ['label' => 'Zadejte název příspěvku'])
          ->add('text', TextAreaType::class, ['label' => 'Zadejte příspěvek', 'attr' => ['rows' => 5]])
          ->add('casopis', EntityType::class, [
                'label' => 'Výběr časopisu',
                'class' => Casopis::class,
                'placeholder' => 'Zvolte časopis',
            ]);
    }
}
