<?php

namespace App\Controller\route;

use App\Entity\Clienti;
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
    #[Route('/clienti', name: 'mostra_clienti')]
    public function getClienti () : Response
    {
        $clienti = $this->em->getRepository(Clienti::class)->findAll();

        return $this->render('clienti/clienti.html.twig',    ['clienti' => $clienti]);
    }
}