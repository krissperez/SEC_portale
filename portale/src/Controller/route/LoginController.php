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

    #[Route('/register', name: 'pagina_registrazione')]
    public function registerPage() : Response
    {
        return $this->render('login/register.html.twig');
    }

    #[Route('/forgotPwd', name: 'pagina_forgotPassword')]
    public function forgotPwdPage() : Response
    {
        return $this->render('login/pwdForgotten.html.twig');
    }
}