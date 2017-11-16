<?php

namespace AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


use AppBundle\Entity\Prispevek;
use AppBundle\Entity\Recenze;
use AppBundle\Entity\Stav;

use AppBundle\Form\RecenzeType;
use AppBundle\Form\RecenzeEditType;

/**
  * @Route("/recenze")
  *
  * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_RECENZENT')")
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

        if ($this->getDoctrine()->getRepository(Recenze::class)->getRecenzeCount($prispevek) >= 2) {
          $prispevek->setStav($em->getReference(Stav::class, 2));
          $em->persist($prispevek);
          $em->flush();
        }

        $this->addFlash('notice', 'Recenze byla úspěšně odeslána.' );

        return $this->redirectToRoute('detail_prispevek_backend', ['prispevek' => $prispevek->getId()]);
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
      $form = $this->createForm(RecenzeEditType::class, $recenze);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
        $em = $this->getDoctrine()->getManager();

        $em->persist($recenze);
        $em->flush();

        $this->addFlash('notice', 'Recenze byla úspěšně editována.' );

        return $this->redirectToRoute('detail_prispevek_backend', ['prispevek' => $recenze->getPrispevek()->getId()]);
      }

      return $this->render(
            'backend/recenze/edit.html.twig',
            [
                'form' => $form->createView(),
                'recenze' => $recenze
            ]
      );
    }
}
