<?php

namespace AppBundle\Controller\Backend;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
  /**
    * @Route("/", name="backpage")
    */
    public function indexAction(Request $request)
    {
      return $this->render('layout/mainBackend.html.twig');
    }

}
