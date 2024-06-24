<?php

namespace App\Controller\route;

use App\Entity\Clienti;
use App\Helper\Formatter;
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
        session_start();
        if(empty($_SESSION['loggedUserId'])){
            return $this->redirectToRoute('pagina_login');
        }

        $clienti = $clientiRepository->findClientsWithAgent();

        foreach ($clienti as $key => $value) {
            Formatter::underscoreToCamelCaseFilter($key);
        }

        return $this->render('clienti/clienti.html.twig', ['clienti' => $clienti]);
    }

    #[Route('/clienti/create', name: 'nuovo_cliente')]
    public function createClient(Request $request)
    {
        return $this->render("clienti/create.html.twig");
    }


}