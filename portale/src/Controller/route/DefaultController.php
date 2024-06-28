<?php

namespace App\Controller\route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;

class DefaultController extends AbstractController
{
    #[Route('/{url}', name: 'catch_all', requirements: ['url' => '.+'])]
    public function notFound(): Response
    {
        return $this->redirectToRoute('home');
    }

}