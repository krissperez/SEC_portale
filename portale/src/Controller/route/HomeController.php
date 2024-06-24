<?php

namespace App\Controller\route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function loginPage() : Response
    {
        session_start();
        if(empty($_SESSION['loggedUserId'])){
            return $this->redirectToRoute('pagina_login');
        }
        return $this->render('home/home.html.twig');
    }


}