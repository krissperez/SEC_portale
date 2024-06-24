<?php

namespace App\Controller\route;

use App\Entity\Agenti;
use App\Entity\Clienti;
use App\Helper\Formatter;
use App\Repository\AgentiRepository;
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
        $agenti = $agentiRepository->findAgentsWhitCap();

        foreach($agenti as $key => $value){
            Formatter::underscoreToCamelCaseFilter($key);
        }

        $agenti = $this->em->getRepository(Agenti::class)->findBy(['deleted_at' => null]);
        return $this->render('agenti/agenti.html.twig',    ['agenti' => $agenti]);
    }

    #[Route('/agenti/create', name: 'nuovo_agente')]
    public function createClient(Request $request)
    {
        return $this->render("/agenti/create.html.twig");
    }




    #[Route('/agenti/add', name: 'aggiungi_agenti', methods: ['GET'])]
    public function setAgenti(): Response
    {
        return $this->render('agenti/addAgenti.html.twig');



    }


}

