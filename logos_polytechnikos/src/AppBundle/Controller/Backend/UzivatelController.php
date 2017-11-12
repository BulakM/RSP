<?php

namespace AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Form\UzivatelType;
use AppBundle\Form\UzivatelEditType;
use AppBundle\Form\PasswordEditType;
use AppBundle\Form\UzivatelFilterType;

use AppBundle\Entity\User;

/**
 * @Route("/uzivatel")
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
        $em = $this->getDoctrine()->getManager();
        $em->persist($uzivatel);
        $em->flush();

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

  /**
    * @Route("/heslo", name="change_heslo")
    */
    public function hesloAction(Request $request)
    {
      $form = $this->createForm(PasswordEditType::class);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
        $em = $this->getDoctrine()->getManager();

        $this->addFlash('notice', 'Vaše heslo bylo úspěšně změněno.' );

        return $this->redirectToRoute('index_uzivatel_backend');
      }

      return $this->render(
            'backend/uzivatel/heslo.html.twig',
            [
                'form' => $form->createView(),
            ]
      );
    }
}
