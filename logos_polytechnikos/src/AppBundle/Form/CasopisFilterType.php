<?php
/**
 * Created by PhpStorm.
 * User: soucekt
 * Date: 11.04.2016
 * Time: 0:13
 */

namespace AppBundle\Form;

use AppBundle\Entity\Tema;
use AppBundle\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class CasopisFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('autor',
            Filters\EntityFilterType::class,
            [
                'class' => User::class,
                'label' => 'Vyhledávání podle autorů',
                'placeholder' => '--- Všechni uživatelé ---'
            ]);

        $builder->add('temata',
            Filters\EntityFilterType::class,
            [
                'class' => Tema::class,
                'label' => 'Vyhledávání podle témat',
                'placeholder' => '--- Všechna témata ---',
            ]);
    }

    public function getBlockPrefix()
    {
        return 'casopis_filter';
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
