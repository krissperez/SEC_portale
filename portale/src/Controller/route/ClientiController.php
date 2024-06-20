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
<<<<<<< HEAD
    #[Route('/clienti', name: 'home')]
=======

    #[Route('/clienti', name: 'show_clienti')]
>>>>>>> refs/remotes/origin/main
    public function getClienti () : Response
    {
        $clienti = $this->em->getRepository(Clienti::class)->findAll();

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