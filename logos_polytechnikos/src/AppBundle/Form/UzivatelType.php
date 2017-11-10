<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('password', TextType::class, ['label' => 'Heslo'])
            ->add('jmeno', TextType::class, ['label' => 'Jméno'])
            ->add('prijmeni', TextType::class, ['label' => 'Príjmení']);
    }
}
