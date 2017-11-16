<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\User;

class UzivatelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->add('username', TextType::class, ['label' => 'Uživatelské jméno'])
            ->add('email', TextType::class, ['label' => 'Email'])
            ->add('jmeno', TextType::class, ['label' => 'Jméno'])
            ->add('prijmeni', TextType::class, ['label' => 'Príjmení'])
            ->add('roles', ChoiceType::class, [
                    'choices' => ['ROLE_ADMIN' => 'ROLE_ADMIN', 'ROLE_REDAKTOR' => 'ROLE_REDAKTOR', 'ROLE_RECENZENT' => 'ROLE_RECENZENT', 'ROLE_EDITOR' => 'ROLE_EDITOR'],
                    'expanded' => true,
                    'multiple' => true,
                ]
            );
    }
}
