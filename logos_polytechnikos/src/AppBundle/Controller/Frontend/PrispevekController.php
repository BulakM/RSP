<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Form\Frontend\PrispevekType;
use AppBundle\Form\Frontend\PrispevekFindType;

use AppBundle\Entity\Prispevek;

class PrispevekController extends Controller
{
  /**
   * @Route("/add/prispevek", name="add_prispevek")
   */
  public function addPrispevekAction(Request $request)
  {
      $prispevek = new Prispevek();

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
            'frontend/prispevek/add.html.twig',
            [
                'form' => $form->createView(),
            ]
      );
  }

  /**
   * @Route("/find/prispevek", name="find_prispevek")
   */
  public function findPrispevekAction(Request $request)
  {
      $form = $this->createForm(PrispevekFindType::class);
      $form->handleRequest($request);

      $prispevek = $this->getDoctrine()->getRepository(Prispevek::class)->findOneBy(['nazev' => $form->get('nazev')->getData()]);

      return $this->render(
            'frontend/prispevek/find.html.twig',
            [
                'form' => $form->createView(),
                'prispevek' => $prispevek,
            ]
      );
  }
}
