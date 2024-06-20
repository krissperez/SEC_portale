<?php

namespace App\Controller\route;

use App\Entity\Clienti;
use App\Helper\Formatter;
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


    #[Route('/clienti', name: 'show_clienti')]
    public function getClienti () : Response
    {
        $clienti = $this->em->getRepository(Clienti::class)->findAll();

        foreach ($clienti as $key => $value) {
            Formatter::underscoreToCamelCaseFilter($key);
        }

        return $this->render('clienti/clienti.html.twig', ['clienti' => $clienti]);
    }
}