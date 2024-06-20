<?php

namespace App\Controller\route;

use App\Entity\Clienti;
use App\Entity\Province;
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
    #[Route('/Clienti', name: 'home')]
    public function getClienti () : Response
    {
        $clienti = $this->em->getRepository(Clienti::class)->findAll();

        return $this->render('clienti/clienti.html.twig', ['clienti' => $clienti]);
    }
}