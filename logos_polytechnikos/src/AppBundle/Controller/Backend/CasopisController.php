<?php

namespace AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Form\CasopisType;
use AppBundle\Form\CasopisFilterType;
use AppBundle\Entity\Casopis;
use AppBundle\Entity\Stav;

/**
  * @Route("/casopis")
  */
class CasopisController extends Controller
{
  /**
    * @Route("/{stav}", name="index_casopis_backend")
    */
    public function indexAction(Request $request, Stav $stav)
    {
      $filter_form = $this->createForm(CasopisFilterType::Class);
      $filter_form->handleRequest($request);

      $casopisy = $this->getDoctrine()->getRepository(Casopis::class)
          ->setPaginatorAndQueryUpdater(
              $this->get('knp_paginator'),
              $this->get('lexik_form_filter.query_builder_updater')
          )
          ->findAllWithPaginator(30, $request->query->getInt('page', 1), $filter_form, false, $stav->getId(), $this->getUser());

      return $this->render('backend/casopis/index.html.twig', array(
        'pagination' => $casopisy,
        'filter_form' => $filter_form->createView()
      ));
    }

  /**
    * @Route("/add", name="add_casopis")
    */
    public function addCasopisAction(Request $request)
    {
      $casopis = new Casopis($this->getUser());

      $form = $this->createForm(CasopisType::class, $casopis);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em->persist($casopis);
        $em->flush();

        $this->addFlash('notice', 'Časopis byl úspéšně odeslán.' );

        return $this->redirectToRoute('index_casopis_backend');
      }

      return $this->render(
            'backend/casopis/add.html.twig',
            [
                'form' => $form->createView(),
            ]
      );
    }

  /**
    * @Route("/upload/{casopis}", name="upload_pdf_under_casopis")
    */
    public function uploadPDFAction(Request $request, Casopis $casopis)
    {
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * @Route("/stav/{casopis}/{stav}", name="zmenit_stav_casopis")
     */
    public function zmenitStavAction(Request $request, Casopis $casopis, $stav)
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
            $stav = $em->getReference(Stav::class, 1); // Schváleno
            break;
          case 2:
            $stav = $em->getReference(Stav::class, 2); // Publikováno
            break;
          default:
            $this->addFlash('error', 'Zadal jste neexistující stav');

            return $this->redirect($_SERVER['HTTP_REFERER']);
        }

        $casopis->setStav($stav);

        $em = $this->getDoctrine()->getManager();
        $em->persist($casopis);
        $em->flush();

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
