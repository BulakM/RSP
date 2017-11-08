<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Stav;

class PrispevekType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
          ->add('nazev', TextType::class, ['label' => 'Zadejte název příspěvku']);
          ->add('text', TextAreaType::class, ['label' => 'Zadejte příspěvek', 'attr' => ['rows' => 5]])
          ->add('casopis', EntityType::class, [
                'label' => 'Stav časopisu',
                'class' => Casopis::class,
                'apply_filter' => function (QueryInterface $queryInterface, $field, $values) {
                  if (!empty($values['value']))
                  {
                      $qb = $queryInterface->getQueryBuilder();
                      $qb->andWhere($qb->expr()->in('c.stav', '1'));
                  }
                }
            ])
          ->add('tema', EntityType::class, [
              'label' => 'Stav časopisu',
              'class' => Stav::class,
            ]);
    }
}
