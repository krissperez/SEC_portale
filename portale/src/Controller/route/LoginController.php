<?php

namespace App\Controller\route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'pagina_login')]
    public function loginPage(Request $request) : Response
    {
        $cookieSessionID = $request->cookies->get('PHPSESSID');

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $sessionId = session_id();

        if (empty($cookieSessionID) || empty($sessionId) || $cookieSessionID !== $sessionId) {
            return $this->render('login/login.html.twig');
        }

        return $this->redirectToRoute('home');


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