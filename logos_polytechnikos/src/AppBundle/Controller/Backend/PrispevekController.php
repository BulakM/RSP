<?php

namespace AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use AppBundle\Form\RecenzeType;
use AppBundle\Form\PrispevekFilterType;
use AppBundle\Form\PrispevekEditType;

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
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editPrispevekAction(Request $request, Prispevek $prispevek)
    {
        $form = $this->createForm(PrispevekEditType::class, $prispevek);
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
              'backend/prispevek/edit.html.twig',
              [
                  'form' => $form->createView(),
                  'prispevek' => $prispevek,
              ]
        );
    }

  /**
    * @Route("/detail/{prispevek}", name="detail_prispevek_backend")
    */
    public function detailAction(Request $request, Prispevek $prispevek)
    {
      return $this->render('backend/prispevek/detail.html.twig', array(
          'prispevek' => $prispevek,
      ));
    }

    /**
     * @Route("/stav/{prispevek}/{stav}", name="zmenit_stav_prispevek")
     */
    public function zmenitStavAction(Request $request, Prispevek $prispevek, $stav)
    {
      $em = $this->getDoctrine()->getManager();

      switch($stav)
      {
        case -1:
            if(!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_EDITOR')){
                throw $this->createAccessDeniedException('Přístup zamítnut');
            }
            $stav = $em->getReference(Stav::class, $stav);
            break;
        case 1:
            if(!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_EDITOR')){
                throw $this->createAccessDeniedException('Přístup zamítnut');
            }
            $stav = $em->getReference(Stav::class, $stav);
            break;
        default:
          $this->addFlash('error', 'Zadal jste neexistující stav');

          return $this->redirect($_SERVER['HTTP_REFERER']);
      }

      $prispevek->setStav($stav);

      $em->persist($prispevek);
      $em->flush();

      return $this->redirect($_SERVER['HTTP_REFERER']);
  }

  /**
    * @Route("/request/{prispevek}", name="request_for_remake")
    *
    * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_EDITOR')")
    */
    public function requestForRemakeAction(Request $request, Prispevek $prispevek)
    {
        $em = $this->getDoctrine()->getManager();

        $prispevek->setStav($em->getReference(Stav::class, -1));

        $em->persist($prispevek);
        $em->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Žádost o předělání příspěvku')
            ->setFrom('info@logos_polytechnikos.cz')
            ->setTo($prispevek->getPrispevatel()->getEmail())
            ->setBody($this->renderView('backend/emaily/rewrite_request.txt.twig', [ 'prispevek' => $prispevek ]), 'text/plain');
        $this->get('mailer')->send($message);

        $this->addFlash('notice', 'Žádost byla úspěště odeslána');

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
