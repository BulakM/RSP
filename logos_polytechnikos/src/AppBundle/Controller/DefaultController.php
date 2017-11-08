<?php

namespace AppBundle\Controller;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
      * @Route("/home", name="homepage")
      * @param Request             $request
      * @param AuthenticationUtils $authUtils
      * @return \Symfony\Component\HttpFoundation\Response
      */
      public function indexAction(Request $request, AuthenticationUtils $authUtils)
      {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('layout/main.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
      }

      public function loginCheckAction()
      {
      }

      public function logoutCheckAction()
      {
      }

      /**
       * @Route("/navigate", name="navigate")
       */
      public function navigateAction()
      {
          return $this->redirectToRoute('home');
      }
}
