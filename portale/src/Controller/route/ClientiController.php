<?php

namespace App\Controller\route;

use App\Entity\Clienti;
use App\Helper\Formatter;
use App\Helper\SessionHandler;
use App\Repository\ClientiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ClientiController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }


    #[Route('/clienti', name: 'mostra_clienti')]
    public function getClientiWithAgents (ClientiRepository $clientiRepository) : Response
    {
        SessionHandler::controlSession();

        $clienti = $clientiRepository->findClientsWithAgent();

        foreach ($clienti as $key => $value) {
            Formatter::underscoreToCamelCaseFilter($key);
        }

        return $this->render('clienti/clienti.html.twig', ['clienti' => $clienti]);
    }

    #[Route('/clienti/create', name: 'nuovo_cliente')]
    public function createClient(Request $request)
    {
        SessionHandler::controlSession();
        return $this->render("clienti/create.html.twig");
    }

    #[Route('/clienti/edit/{id}', name: 'modifica_cliente')]
    public function editClient(int $id, ClientiRepository $clientiRepository, Request $request): Response
    {
        SessionHandler::controlSession();

        $cliente = $clientiRepository->findOneBy(['id' => $id]);

        if (!$cliente) {
            throw $this->createNotFoundException('Cliente non trovato');
        }


        return $this->render('clienti/edit.html.twig', ['cliente' => $cliente]);
    }


}