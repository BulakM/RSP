<?php

namespace AppBundle\Controller\Backend;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use AppBundle\Form\UzivatelType;
use AppBundle\Form\UzivatelEditType;
use AppBundle\Form\PasswordEditType;
use AppBundle\Form\UzivatelFilterType;

use AppBundle\Entity\User;

/**
 * @Route("/uzivatel")
 *
 * @Security("is_granted('ROLE_ADMIN')")
*/
class UzivatelController extends Controller
{
    /**
     * @Route("/", name="index_uzivatel_backend")
    */
    public function indexAction(Request $request)
    {
      $filter_form = $this->createForm(UzivatelFilterType::Class);
      $filter_form->handleRequest($request);

      $uzivatele = $this->getDoctrine()->getRepository(User::class)
          ->setPaginatorAndQueryUpdater(
              $this->get('knp_paginator'),
              $this->get('lexik_form_filter.query_builder_updater')
          )
          ->findAllWithPaginator(30, $request->query->getInt('page', 1), $filter_form);

      return $this->render('backend/uzivatel/index.html.twig', array(
        'pagination' => $uzivatele,
        'filter_form' => $filter_form->createView()
      ));
    }

  /**
    * @Route("/add", name="add_uzivatel")
    */
    public function addUzivatelAction(Request $request)
    {
      $uzivatel = new User();

      $form = $this->createForm(UzivatelType::class, $uzivatel);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
        $tokenGenerator = $this->get('fos_user.util.token_generator');
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($uzivatel);
        $heslo = substr($tokenGenerator->generateToken(), 0, 12);

        $heslo_enc = $encoder->encodePassword($heslo, $uzivatel->getSalt());

        $uzivatel->setPassword($heslo_enc);
        $uzivatel->setEnabled(1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($uzivatel);
        $em->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Vytvoření účtu u logos_polytechnikos')
            ->setFrom('info@logos_polytechnikos.cz')
            ->setTo($form->get('email')->getData())
            ->setBody($this->renderView('backend/emaily/new_user.txt.twig', [ 'uzivatel' => $uzivatel, 'heslo' => $heslo ]), 'text/plain');
        $this->get('mailer')->send($message);

        $this->addFlash('notice', 'Uživatel byl úspéšně uložen.' );

        return $this->redirectToRoute('index_uzivatel_backend');
      }

      return $this->render(
            'backend/uzivatel/add.html.twig',
            [
                'form' => $form->createView(),
            ]
      );
    }

    /**
      * @Route("/edit/{uzivatel}", name="edit_uzivatel")
      */
      public function editUzivatelAction(Request $request, User $uzivatel)
      {
        $form = $this->createForm(UzivatelEditType::class, $uzivatel);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
          $em = $this->getDoctrine()->getManager();
          $em->persist($uzivatel);
          $em->flush();

          $this->addFlash('notice', 'Uživatel byl úspéšně uložen.' );

          return $this->redirectToRoute('index_uzivatel_backend');
        }

        return $this->render(
              'backend/uzivatel/edit.html.twig',
              [
                  'form' => $form->createView(),
                  'uzivatel' => $uzivatel
              ]
        );
      }
}
