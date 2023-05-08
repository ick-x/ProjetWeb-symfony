<?php

namespace App\Controller;

use App\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $request): Response
    {
        if($this->getUser()==null)
            return $this->redirectToRoute("app_login");
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
            'current_user'=> $this->getUser()
        ]);
    }
}
