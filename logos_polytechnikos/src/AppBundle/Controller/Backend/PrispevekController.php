<?php

namespace AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Form\RecenzeType;
use AppBundle\Form\PrispevekFilterType;

use AppBundle\Entity\Prispevek;
use AppBundle\Entity\Stav;

/**
  * @Route("/prispevek")
  */
class PrispevekController extends Controller
{
  /**
    * @Route("/{stav}", name="index_prispevek_backend")
    */
    public function indexAction(Request $request, Stav $stav)
    {
      $filter_form = $this->createForm(PrispevekFilterType::Class);
      $filter_form->handleRequest($request);

      $prispevky = $this->getDoctrine()->getRepository(Prispevek::class)
          ->setPaginatorAndQueryUpdater(
              $this->get('knp_paginator'),
              $this->get('lexik_form_filter.query_builder_updater')
          )
          ->findAllWithPaginator(30, $request->query->getInt('page', 1), $filter_form, $stav->getId(), $this->getUser());

      return $this->render('backend/prispevek/index.html.twig', array(
        'pagination' => $prispevky,
        'filter_form' => $filter_form->createView(),
        'stav' => $stav
      ));
    }

    /**
     * @Route("/edit/{prispevek}", name="edit_prispevek")
     */
    public function editPrispevekAction(Request $request, Prispevek $prispevek)
    {
        $form = $this->createForm(PrispevekType::class, $prispevek);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prispevek);
            $em->flush();

            $this->addFlash('notice', 'Příspěvek byl úspéšně odeslán.' );

            return $this->render('frontend/casopis/index.html.twig');
        }

        return $this->render(
              'frontend/prispevek/edit.html.twig',
              [
                  'form' => $form->createView(),
              ]
        );
    }

  /**
    * @Route("/detail/{prispevek}", name="detail_prispevek_backend")
    */
    public function detailAction(Request $request, Prispevek $prispevek)
    {
      return $this->render('backend/prispevek/index.html.twig', array(
          'prispevek' => $prispevek,
      ));
    }

    /**
     * @Route("/stav/{prispevek}/{stav}", name="zmenit_stav_prispevek")
     */
    public function zmenitStavAction(Request $request, Prispevek $prispevek, $stav)
    {
      switch($stav)
      {
        case -1:
          $stav = $em->getReference(Stav::class, -1); // Smazáno
          break;
        case 0:
          $stav = $em->getReference(Stav::class, 0); // Ke schválení
          break;
        case 1:
          $stav = $em->getReference(Stav::class, 1); // V recenzní řízení
          break;
        case 2:
          $stav = $em->getReference(Stav::class, 2); // Schváleno
          break;
        case 3:
          $stav = $em->getReference(Stav::class, 3); // Publikováno
          break;
        default:
          $this->addFlash('error', 'Zadal jste neexistující stav');

          return $this->redirect($_SERVER['HTTP_REFERER']);
      }

      $prispevek->setStav($stav);

      $em = $this->getDoctrine()->getManager();
      $em->persist($prispevek);
      $em->flush();

      return $this->redirect($_SERVER['HTTP_REFERER']);
  }
}
