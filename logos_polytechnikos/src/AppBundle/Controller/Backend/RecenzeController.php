<?php

namespace AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


use AppBundle\Entity\Prispevek;
use AppBundle\Entity\Recenze;

use AppBundle\Form\RecenzeType;

/**
  * @Route("/recenze")
  */
class RecenzeController extends Controller
{
  /**
    * @Route("/add/{prispevek}", name="add_recenzi")
    */
    public function addRecenziAction(Request $request, Prispevek $prispevek)
    {
      $recenze = new Recenze($this->getUser(), $prispevek);

      $form = $this->createForm(RecenzeType::class, $recenze);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em->persist($recenze);
        $em->flush();

        $this->addFlash('notice', 'Recenze byla úspěšně odeslána.' );

        return $this->redirectToRoute('detail_prispevek_backend', ['prispevek' => $prispevek]);
      }

      return $this->render(
            'backend/recenze/add.html.twig',
            [
                'form' => $form->createView(),
            ]
      );
    }
}
