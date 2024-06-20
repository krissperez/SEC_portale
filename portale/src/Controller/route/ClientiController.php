<?php

namespace App\Controller\route;

use App\Entity\Clienti;
use App\Helper\Formatter;
use App\Repository\ClientiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ClientiController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
<<<<<<< HEAD
    #[Route('/clienti', name: 'mostra_clienti')]
    public function getClienti () : Response
=======

    #[Route('/clienti', name: 'show_clienti')]
    public function getClientiWithAgents (ClientiRepository $clientiRepository) : Response
>>>>>>> refs/remotes/origin/main
    {
        $clienti = $clientiRepository->findClientsWithAgent();

<<<<<<< HEAD
        return $this->render('clienti/clienti.html.twig',    ['clienti' => $clienti]);
=======
        foreach ($clienti as $key => $value) {
            Formatter::underscoreToCamelCaseFilter($key);
        }

        return $this->render('clienti/clienti.html.twig', ['clienti' => $clienti]);
>>>>>>> refs/remotes/origin/main
    }
}