<?php

namespace App\Controller;

use App\Entity\Province;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    #[Route('/api/utenti', name: 'home')]
    public function getUtenti () : Response
    {
        $cap = $this->em->getRepository(Province::class)->findAll();

        return $this->json($cap);
    }
}