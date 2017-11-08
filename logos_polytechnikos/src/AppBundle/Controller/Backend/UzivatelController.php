<?php

namespace AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Form\UzivatelType;

use AppBundle\Entity\User;

/**
 * @Route("/uzivatel")
*/
class UzivatelController extends Controller
{
    /**
     * @Route("/", name="index_uzivatel_uzivatel")
    */
    public function indexAction(Request $request)
    {
        $uzivatele = $this->getDoctrine()->getRepository(User::class)->findAll();

        return [
            'pagination' => $uzivatele
        ];
    }

  /**
    * @Route("/add", name="add_uzivatel")
    */
    public function addCasopisAction(Request $request)
    {
      $uzivatel = new User();

      $form = $this->createForm(UzivatelType::class, $uzivatel);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em->persist($uzivatel);
        $em->flush();

        $this->addFlash('notice', 'Uživatel byl úspéšně uložen.' );

        return $this->redirectToRoute('index_uzivatel_backend');
      }

      return $this->render(
            'backend/uzivatel/add.html.twig',
            [
                'form' => $form->createView(),
            ]
      );
    }
}
