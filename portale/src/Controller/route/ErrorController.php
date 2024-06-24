<?php

namespace App\Controller\route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{

    #[Route('/error', name: 'error_page')]
    public function showError(Request $request) : Response
    {
        $errorMessage = $request->query->get('error_message');

        return $this->render('error/error.html.twig', [
            'error_message' => $errorMessage,
        ]);
    }

}