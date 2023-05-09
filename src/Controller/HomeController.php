<?php

namespace App\Controller;

use App\Entity\User;
use App\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    public function __construct(private Security $security){}
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        if($this->security->isGranted("IS_AUTHENTICATED"))
            return $this->render("home/index.html.twig",["user"=> $this->getUser()]);

        return $this->render("home/index.html.twig",["user"=>new User()]);
    }
}
