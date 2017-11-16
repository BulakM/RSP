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
      $prispevek = new Prispevek();
      $form = $this->createForm(PrispevekType::class, $prispevek);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
          $em = $this->getDoctrine()->getManager();

          $prispevatel = $this->getDoctrine()->getRepository(Prispevatel::class)->findOneByEmail($request->request->get('prispevek')['prispevatel_email']);

          if ($prispevatel == null) {
            $prispevatel = new Prispevatel($request->request->get('prispevek')['prispevatel_email']);

            $em->persist($prispevatel);
            $em->flush();
          }

          $prispevek->setHash(md5($prispevek->getNazev().$prispevatel->getEmail().uniqid()));
          $prispevek->setPrispevatel($prispevatel);
          $prispevek->setStav($em->getReference(Stav::class, 0));

          $em->persist($prispevek);
          $em->flush();

          $message = \Swift_Message::newInstance()
              ->setSubject('Odeslání příspěvku k výběrovému řízení')
              ->setFrom('info@logos_polytechnikos.cz')
              ->setTo($request->request->get('prispevek')['prispevatel_email'])
              ->setBody($this->renderView('backend/emaily/new_prispevek.txt.twig', [ 'prispevek' => $prispevek ]), 'text/plain');
          $this->get('mailer')->send($message);

          $this->addFlash('notice', 'Příspěvek byl úspéšně odeslán.' );

          return $this->redirectToRoute('index_casopis');
      }

      return $this->render(
            'frontend/prispevek/add.html.twig',
            [
                'form' => $form->createView()
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

    public function imap_utf8_fix($string) {
        return iconv_mime_decode($string,0,"UTF-8");
    }
}
