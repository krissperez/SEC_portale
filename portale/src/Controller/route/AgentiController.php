<?php

namespace App\Controller\route;

use App\Entity\Agenti;
use App\Entity\Clienti;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgentiController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em){
        $this ->em = $em;

    }

    #[Route('/agenti', name: 'mostra_agenti')]
    public function getAgenti(): Response
    {
        $agenti = $this->em->getRepository(Agenti::class)->findBy(['deleted_at' => null]);
        return $this->render('agenti/agenti.html.twig',    ['agenti' => $agenti]);
    }


}

