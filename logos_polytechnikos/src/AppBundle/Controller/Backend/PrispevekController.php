<?php

namespace AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Form\RecenzeType;

use AppBundle\Entity\Prispevek;
use AppBundle\Entity\Stav;

/**
  * @Route("/prispevek")
  */
class PrispevekController extends Controller
{
  /**
    * @Route("/", name="index_prispevek_backend")
    */
    public function indexAction(Request $request)
    {
      $prispevky = $this->getDoctrine()->getRepository(Prispevek::class)->findAll();

      return $this->render('backend/prispevek/index.html.twig', array(
          'pagination' => $prispevky,
      ));
    }

  /**
    * @Route("/detail/{prispevek}", name="detail_prispevek_backend")
    */
    public function detailAction(Request $request, Prispevek $prispevek)
    {
      return $this->render('backend/prispevek/index.html.twig', array(
          'prispevek' => $prispevek,
      ));
    }

    /**
     * @Route("/stav/{prispevek}/{stav}", name="zmenit_stav_prispevek")
     */
    public function zmenitStavAction(Request $request, Prispevek $prispevek, $stav)
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
        case 3:
          $stav = $em->getReference(Stav::class, 3); // V recenzní řízení
          break;
        default:
          $this->addFlash('error', 'Zadal jste neexistující stav');

          return $this->redirect($_SERVER['HTTP_REFERER']);
      }

      $prispevek->setStav($stav);

      $em = $this->getDoctrine()->getManager();
      $em->persist($prispevek);
      $em->flush();

      return $this->redirect($_SERVER['HTTP_REFERER']);
  }

/**
  * @Route("/add/recenze/{prispevek}", name="add_recenze_to_casopis")
  */
  public function addRecenziToPrispevekAction(Request $request, Prispevek $prispevek)
  {
    $recenze = new Recenze($this->getUser());

    $form = $this->createForm(RecenzeType::class, $recenze);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {
      $em = $this->getDoctrine()->getManager();
      $em->persist($form);
      $em->flush();

      $this->addFlash('notice', 'Recenze byla úspěšně odeslána' );

      return $this->redirectToRoute('index_prispevek_backend');
    }

    return $this->render(
          'backend/prispevek/addRecenze.html.twig',
          [
              'form' => $form->createView(),
              'prispevek' => $prispevek,
          ]
    );
  }
}
