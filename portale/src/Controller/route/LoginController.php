<?php

namespace App\Controller\route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'pagina_login')]
    public function loginPage() : Response
    {
        return $this->render('login/login.html.twig');
    }
}