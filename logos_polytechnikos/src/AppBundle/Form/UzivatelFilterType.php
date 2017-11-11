<?php
/**
 * Created by PhpStorm.
 * User: soucekt
 * Date: 11.04.2016
 * Time: 0:13
 */

namespace AppBundle\Form;

use AppBundle\Entity\Mesta;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class UzivatelFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fulltext', Filters\TextFilterType::class, [
            'label' => 'Hledání v uživatelých',
            'apply_filter' => function (QueryInterface $queryInterface, $field, $values) {
                if (!empty($values['value']))
                {
                    $value = '%' . $values['value'] . '%';

                    /** @var QueryBuilder $qb */
                    $qb = $queryInterface->getQueryBuilder();
                    $qb
                        ->andWhere($qb->expr()->orX(
                            $qb->expr()->like('lower(u.jmeno)', 'lower(:value)'),
                            $qb->expr()->like('lower(u.prijmeni)', 'lower(:value)'),
                            $qb->expr()->like('lower(u.username)', 'lower(:value)'),
                            $qb->expr()->like('lower(u.email)', 'lower(:value)')
                        ))
                        ->setParameter('value', $value);
                    ;
                }
            }
        ]);
    }

    public function getBlockPrefix()
    {
        return 'user_filter';
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
