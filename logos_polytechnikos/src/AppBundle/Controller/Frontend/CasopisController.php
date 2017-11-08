<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Casopis;

class CasopisController extends Controller
{
  /**
    * @Route("/casopis", name="index_casopis")
    */
    public function indexAction(Request $request)
    {
      $casopisy = $this->getDoctrine()->getRepository(Casopis::class)->findBy(['stav' => '1'], ['datumVytvoreni' => 'DESC']);

      return $this->render('layout/mainBackend.html.twig', array(
          'pagination' => $casopisy,
      ));
    }

    /**
      * @Route("/casopis", name="index_casopis")
      */
      public function downloadAction(Request $request)
      {
        $file = null; // Stáhnout balík pro správu souborů

        $response = new BinaryFileResponse($file);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
      }
}
