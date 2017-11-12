<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Stav;
use AppBundle\Entity\Tema;
use AppBundle\Entity\Casopis;

class PrispevekType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
          ->add('prispevek_nazev', TextType::class, ['label' => 'Zadejte název příspěvku'])
          ->add('prispevatel_email', TextType::class, ['label' => 'Zadejte váš email'])
          ->add('prispevek_text', TextAreaType::class, ['label' => 'Zadejte příspěvek', 'attr' => ['rows' => 5]])
          ->add('prispevek_casopis', EntityType::class, [
                'mapped' => false,
                'label' => 'Výběr časopisu',
                'class' => Casopis::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                                ->where('c.stav = 2')
                                ->orderBy('c.id', 'DESC');
                },
                'placeholder' => 'Zvolte časopis',
            ])
          ->add('prispevek_tema', ChoiceType::class, array('label' => 'Vyberte téma'));
    }
}
