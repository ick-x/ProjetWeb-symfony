<?php

namespace App\Controller;

use App\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function __construct(private Helper $helper){
    }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if($this->getUser()==null)
            return $this->redirectToRoute("app_login");
        return $this->render("home/index.html.twig",[
            "user"=>$this->helper->getUser()
        ]);
    }
}
