<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Form\PrispevekType;
use AppBundle\Form\PrispevekFindType;

use AppBundle\Entity\Prispevatel;
use AppBundle\Entity\Prispevek;
use AppBundle\Entity\Casopis;
use AppBundle\Entity\Tema;
use AppBundle\Entity\Stav;

/**
 * @Route("/prispevek")
 */
class PrispevekController extends Controller
{
  /**
   * @Route("/add", name="add_prispevek")
   */
  public function addPrispevekAction(Request $request)
  {
      $form = $this->createForm(PrispevekType::class);
      $form->handleRequest($request);

      if($form->isSubmitted())
      {
          $em = $this->getDoctrine()->getManager();

          $prispevatel = $this->getDoctrine()->getRepository(Prispevatel::class)->findOneByEmail($request->request->get('prispevek')['prispevatel_email']);
          $casopis = $this->getDoctrine()->getRepository(Casopis::class)->findOneById($request->request->get('prispevek')['prispevek_casopis']);
          $tema = $this->getDoctrine()->getRepository(Tema::class)->findOneById($request->request->get('prispevek')['prispevek_tema']);

          if ($prispevatel == null) {
            $prispevatel = new Prispevatel($request->request->get('prispevek')['prispevatel_email']);

            $em->persist($prispevatel);
            $em->flush();
          }

          $prispevek = new Prispevek($em->getReference(Stav::class, 0), $casopis, $prispevatel, $tema);
          $prispevek->setHash(md5($request->request->get('prispevek')['prispevek_nazev'].$request->request->get('prispevek')['prispevatel_email']));
          $prispevek->setNazev($request->request->get('prispevek')['prispevek_nazev']);
          $prispevek->setText($request->request->get('prispevek')['prispevek_text']);

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
   * @Route("/find", name="find_prispevek")
   */
  public function findPrispevekAction(Request $request)
  {
      $form = $this->createForm(PrispevekFindType::class);
      $form->handleRequest($request);
      $prispevek = null;

      if($form->isSubmitted() && $form->isValid())
      {
        $prispevek = $this->getDoctrine()->getRepository(Prispevek::class)->findOneBy(['hash' => $form->getData()['hash']]);
      }

      return $this->render(
            'frontend/prispevek/find.html.twig',
            [
                'form' => $form->createView(),
                'prispevek' => $prispevek,
            ]
      );
  }

    /**
     * @Route("/get_temata/{casopis}", options={"expose"=true}, name="get_temata_for_casopis")
     */
    public function getTemataForCasopisAction(Request $request, Casopis $casopis)
    {
      $temata = $casopis->getTemata();

      foreach ($temata as $key => $tema) {
        $options[$key]['id'] = $tema->getId();
        $options[$key]['nazev'] = $tema->getNazev();
      }

      $response = new Response(json_encode(array('options' => $options)));
      $response->headers->set('Content-Type', 'application/json');

      return $response;
    }
}
