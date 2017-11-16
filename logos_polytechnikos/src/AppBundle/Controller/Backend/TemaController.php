<?php

namespace AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use AppBundle\Entity\Tema;

use AppBundle\Form\TemaType;

/**
 * @Route("/tema")
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_REDAKTOR')")
*/
class TemaController extends Controller
{
  /**
    * @Route("/add", name="add_tema")
    *
    */
    public function addTemaAction(Request $request)
    {
      $tema = new Tema();

      $form = $this->createForm(TemaType::class, $tema);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em->persist($tema);
        $em->flush();

        $this->addFlash('notice', 'Téma bylo úspěštně uloženo.' );

        return $this->redirect($_SERVER['HTTP_REFERER']);
      }

      return $this->render(
            'backend/tema/index.html.twig',
            [
                'form' => $form->createView(),
                'temata' => $this->getDoctrine()->getRepository(Tema::class)->findBy([], ['aktivni' => 'DESC', 'nazev' => 'ASC'])
            ]
      );
    }

    /**
      * @Route("/toggle/{tema}", name="toggle_tema")
      */
      public function toggleAction(Request $request, Tema $tema)
      {
        $em = $this->getDoctrine()->getManager();

        $tema->setAktivni(!$tema->getAktivni());

        $em->persist($tema);
        $em->flush();

        return $this->redirect($_SERVER['HTTP_REFERER']);
      }
}
