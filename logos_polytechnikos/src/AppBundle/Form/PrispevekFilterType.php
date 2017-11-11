<?php
/**
 * Created by PhpStorm.
 * User: soucekt
 * Date: 11.04.2016
 * Time: 0:13
 */

namespace AppBundle\Form;

use AppBundle\Entity\Tema;
use AppBundle\Entity\Casopis;
use AppBundle\Entity\Prispevatel;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class PrispevekFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fulltext', Filters\TextFilterType::class, [
            'label' => 'Hledání v textu',
            'apply_filter' => function (QueryInterface $queryInterface, $field, $values) {
                if (!empty($values['value']))
                {
                    $value = '%' . $values['value'] . '%';

                    /** @var QueryBuilder $qb */
                    $qb = $queryInterface->getQueryBuilder();
                    $qb
                        ->andWhere($qb->expr()->orX(
                            $qb->expr()->like('lower(p.nazev)', 'lower(:value)'),
                            $qb->expr()->like('lower(o.text)', 'lower(:value)')
                        ))
                        ->setParameter('value', $value);
                    ;
                }
            }
        ]);
        $builder->add('tema',
            Filters\EntityFilterType::class,
            [
                'class' => Tema::class,
                'label' => 'Vyhledávání podle témat',
                'placeholder' => '--- Všechna témata ---',
            ]);
        $builder->add('casopis',
            Filters\EntityFilterType::class,
            [
                'class' => Casopis::class,
                'label' => 'Vyhledávání podle časopisu',
                'placeholder' => '--- Všechny časopisy ---',
            ]);
        $builder->add('prispevatel',
            Filters\EntityFilterType::class,
            [
                'class' => Prispevatel::class,
                'label' => 'Vyhledávání podle přispěvatelů',
                'placeholder' => '--- Všichni přispěvatelé ---',
            ]);
    }

    public function getBlockPrefix()
    {
        return 'prispevek_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true,
            'csrf_protection'   => false,
            'validation_groups' => array('filtering'),
            'method' => 'get',
        ));
    }
}
