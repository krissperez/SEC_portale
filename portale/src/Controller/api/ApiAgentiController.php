<?php

namespace App\Command;

use App\Entity\Agenti;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiAgentiController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    #[Route('/api/agenti', name: "createCliente", methods: ["POST"])]
    public function createAgenti (Request $request) : Response
    {
        try{
            $data = $request->toArray();

            if(empty($data['nome']) || empty($data['cognome']) ){
                throw new \Exception("All fields are required");

            }

            if(strlen($data['nome']) <= 2  || strlen($data['cognome']) <= 2){
                throw new \Exception("Invalid name");
            }

            $agente = new Agenti();
            $agente->setNome($data['nome']);
            $agente->setCognome($data['cognome']);

            $this->em->persist($agente);
            $this->em->flush();

            return $this->json([
                "ok"=> true,
                'message' => 'Agente creato',
                'id' => $agente->getId()
            ], 200);
        }catch (\Exception $e){
            return $this->json([
                'ok'=> false,
                'message' => "{$e->getMessage()} in line {$e->getLine()}",
            ], $e->getCode());
        }
    }
}