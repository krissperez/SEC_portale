<?php

namespace App\Controller\api;

use App\Helper\SessionHandler;
use App\Repository\CapRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiCapController extends AbstractController
{
    #[Route('/api/cap/liberi', name: 'aggiungi_agenti', methods: ['GET'])]
    public function setAgenti(CapRepository $capRepository): Response{

        SessionHandler::controlSession();
        $capLiberi = $capRepository->capLiberi();



        return $this->json( ['cap_liberi' => $capLiberi]);
    }

}