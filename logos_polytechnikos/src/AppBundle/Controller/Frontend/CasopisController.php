<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Casopis;

use AppBundle\Form\CasopisFilterType;

/**
  * @Route("/casopis")
  */
class CasopisController extends Controller
{
  /**
    * @Route("/", name="index_casopis")
    */
    public function indexAction(Request $request)
    {
      $filter_form = $this->createForm(CasopisFilterType::Class);
      $filter_form->handleRequest($request);

      $casopisy = $this->getDoctrine()->getRepository(Casopis::class)
          ->setPaginatorAndQueryUpdater(
              $this->get('knp_paginator'),
              $this->get('lexik_form_filter.query_builder_updater')
          )
          ->findAllWithPaginator(30, $request->query->getInt('page', 1), $filter_form, true);

      return $this->render('frontend/casopis/index.html.twig', array(
        'pagination' => $casopisy,
        'filter_form' => $filter_form->createView()
      ));
    }
}
