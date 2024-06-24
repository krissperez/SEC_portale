<?php

namespace App\Controller\route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GraficaController extends AbstractController
{
    #[Route('/grafica', name: 'mostra_grafica', methods: ['GET'])]
    public function loginPage() : Response
    {

        return $this->render('grafica/grafica.html.twig');
    }
}