<?php

namespace AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


use AppBundle\Entity\Prispevek;
use AppBundle\Entity\Recenze;
use AppBundle\Entity\Stav;

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

        $count = 0;
        foreach ($prispevek->getRecenze() as $recenze) {
          if ($recenze->getOdbornost() + $recenze->getZajimavost() + $recenze->getAktualnost() > 7) {
            $count++;
          }
        }

        if ($count >= 2) {
          $prispevek->setStav($em->getReference(Stav::class, 2));
        }
        else {
          $prispevek->setStav($em->getReference(Stav::class, 1));
        }

        $em->persist($recenze);
        $em->persist($prispevek);
        $em->flush();

        $this->addFlash('notice', 'Recenze byla úspěšně odeslána.' );

        return $this->redirectToRoute('detail_prispevek_backend', ['prispevek' => $prispevek]);
      }

      return $this->render(
            'backend/recenze/add.html.twig',
            [
                'form' => $form->createView(),
                'prispevek' => $prispevek
            ]
      );
    }

  /**
    * @Route("/edit/{recenze}", name="edit_recenze")
    */
    public function editRecenziAction(Request $request, Recenze $recenze)
    {
      $form = $this->createForm(RecenzeType::class, $recenze);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
        $em = $this->getDoctrine()->getManager();

        $count = 0;
        foreach ($recenze->getPrispevek()->getRecenze() as $recenze) {
          if ($recenze->getOdbornost() + $recenze->getZajimavost() + $recenze->getAktualnost() > 7) {
            $count++;
          }
        }

        if ($count >= 2) {
          $prispevek->setStav($em->getReference(Stav::class, 2));
        }
        else {
          $prispevek->setStav($em->getReference(Stav::class, 1));
        }

        $em->persist($recenze);
        $em->persist($prispevek);
        $em->flush();

        $this->addFlash('notice', 'Recenze byla úspěšně editována.' );

        return $this->redirectToRoute('detail_prispevek_backend', ['prispevek' => $prispevek]);
      }

      return $this->render(
            'backend/recenze/add.html.twig',
            [
                'form' => $form->createView(),
                'recenze' => $recenze
            ]
      );
    }
}
