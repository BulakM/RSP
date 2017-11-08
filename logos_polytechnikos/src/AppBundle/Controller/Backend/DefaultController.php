<?php

namespace AppBundle\Controller\Backend;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
  * @Route("/redakce")
  */
class DefaultController extends Controller
{
  /**
    * @Route("/", name="backpage")
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

      return $this->render('layout/mainBackend.html.twig', array(
          'last_username' => $lastUsername,
          'error'         => $error,
      ));
    }

}
