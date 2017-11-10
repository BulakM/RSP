<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Casopis;

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
      $casopisy = $this->getDoctrine()->getRepository(Casopis::class)->findAll();

      return $this->render('frontend/casopis/index.html.twig', array(
          'pagination' => $casopisy,
      ));
    }

    /**
      * @Route("/download/{casopis}", name="download_casopis")
      */
      public function downloadAction(Request $request, Casopis $casopis)
      {
        $file = null; // Stáhnout balík pro správu souborů

        $response = new BinaryFileResponse($file);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
      }
}
