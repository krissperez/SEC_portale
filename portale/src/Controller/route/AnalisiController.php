<?php

namespace App\Controller\route;

use App\Helper\SessionHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnalisiController extends AbstractController
{
    #[Route('/analisi', name: 'mostra_analisi', methods: ['GET'])]
    public function loginPage() : Response
    {
        SessionHandler::controlSession();

        return $this->render('analisi/analisi.html.twig');
    }
}