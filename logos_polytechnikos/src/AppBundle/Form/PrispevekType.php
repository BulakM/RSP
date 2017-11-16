<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Stav;
use AppBundle\Entity\Tema;
use AppBundle\Entity\Casopis;
use AppBundle\Entity\Prispevek;

class PrispevekType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
          ->add('nazev', TextType::class, ['label' => 'Zadejte název příspěvku'])
          ->add('prispevatel_email', TextType::class, ['label' => 'Zadejte váš email', 'mapped' => false])
          ->add('text', TextAreaType::class, ['label' => 'Zadejte příspěvek', 'attr' => ['rows' => 5]])
          ->add('casopis', EntityType::class, [
                'label' => 'Výběr časopisu',
                'class' => Casopis::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                                ->where('c.stav = 2 AND c.uzaverka > :now')
                                ->orderBy('c.id', 'DESC')
                                ->setParameter('now', new \DateTime('now'));
                },
                'placeholder' => 'Zvolte časopis',
            ]);

        $formModifier = function (FormInterface $form, Casopis $casopis = null) {
            $temata = null === $casopis ? array() : $casopis->getTemata();

            $form->add('tema', EntityType::class, array(
                'label' => 'Vyberte téma',
                'class' => Tema::class,
                'placeholder' => (isset($temata[0])) ? 'Vyberte jedno z témat' : 'Žádné téma není k disposici',
                'choices' => $temata,
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getCasopis());
            }
        );

        $builder->get('casopis')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $casopis = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $casopis);
            }
        );
    }
}
