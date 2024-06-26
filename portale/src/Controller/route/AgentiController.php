<?php

namespace App\Controller\route;

use App\Helper\Formatter;
use App\Helper\SessionHandler;
use App\Repository\AgentiRepository;
use App\Repository\CapRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgentiController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em){
        $this ->em = $em;

    }

    #[Route('/agenti', name: 'mostra_agenti', methods: ['GET'])]
    public function getAgentiWhitCap(AgentiRepository $agentiRepository): Response
    {
        SessionHandler::controlSession();

        $agenti = $agentiRepository->findAgentsWhitCap();

        foreach($agenti as $key => $value){
            Formatter::underscoreToCamelCaseFilter($key);
        }

        return $this->render('agenti/agenti.html.twig', ['agenti' => $agenti]);
    }


    #[Route('/agenti/create', name: 'nuovo_agente')]
    public function createClient(Request $request)
    {
        SessionHandler::controlSession();

        return $this->render("/agenti/create.html.twig");
    }







}

