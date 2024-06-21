<?php

namespace App\Controller\api;

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
    #[Route('/api/agents', name: "creare_agente", methods: ["POST"])]
    public function createAgent (Request $request) : Response
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

    #[Route('/api/agents/{id}', name: "cancella_agente", methods: ["DELETE"])]
    public function deleteAgentById(int $id){
        try{
            $repo = $this->em->getRepository(Agenti::class);

            /**@var Agenti $agent*/
            $agent = $repo->findOneBy(['deleted_at' => null, 'id' => $id]);


            if(empty($agent)){
                throw new \Exception("Agent not found", 422);
            }

            $curDate = new \DateTime();
            $agent->setDeletedAt($curDate);

            $this->em->persist($agent);
            $this->em->flush();

            return $this->json([
                'ok' => true,
                'message' => "client deleted",
            ]);

        }catch (\Exception $e){
            return $this->json([
                'ok' => false,
                "error" => "{$e->getMessage()}",
            ], $e->getCode());
        }
    }

    #[Route('/api/agents', name: "cancella_agente", methods: ["GET"])]
    public function getAgents(){
        try{
            $repo = $this->em->getRepository(Agenti::class);
            $agents = $repo->findBy(['deleted_at' => null]);


            return $this->json([
                'ok' => true,
                'message' => "client deleted",
                'data' => $agents
            ]);

        }catch (\Exception $e){
            return $this->json([
                'ok' => false,
                "error" => "{$e->getMessage()}",
            ], $e->getCode());
        }
    }

    #[Route('/api/agents/{id}', name: "prendi_agente", methods: ["GET"])]
    public function getAgent (int $id) : Response
    {
        try{
            $repo = $this->em->getRepository(Agenti::class);

            $agent = $repo->findOneBy(['deleted_at' => null, 'id' => $id]);

            if(empty($agent)){
                throw new \Exception("Agent not found", 422);
            }

            return $this->json([
                'ok' => true,
                'message' => "client retrived",
                'data' => $agent
            ]);

        }catch (\Exception $e){
            return $this->json([
                'ok' => false,
                "error" => "{$e->getMessage()}",
            ], $e->getCode());
        }
    }

    #[Route('/api/agents/{id}', name: "prendi_agente", methods: ["PUT"])]
    public function editAgent (Request $request, int $id) : Response
    {
        try{
            $repo = $this->em->getRepository(Agenti::class);

            $agent = $repo->findOneBy(['deleted_at' => null, 'id' => $id]);

            if(empty($agent)){
                throw new \Exception("Agent not found", 422);
            }

            $data = $request->toArray();
            $name = isset($data['nome']) ? trim($data['nome']) : $agent->getNome();
            $surname = isset($data['cognome']) ? trim($data['cognome']) : $agent->getCognome();

            if(empty($name) || empty($surname) ){
                throw new \Exception("All fields are required", 422);
            }

            if(strlen($name) <= 2){
                throw new \Exception("Invalid name", 422);
            }

            if(strlen($surname) <= 2){
                throw new \Exception("Invalid surname", 422);
            }

            $agent->setNome($name);
            $agent->setCognome($surname);
            $this->em->persist($agent);
            $this->em->flush();

            return $this->json([
                'ok' => true,
                'message' => "client edited",
                'data' => $agent
            ]);

        }catch (\Exception $e){
            return $this->json([
                'ok' => false,
                "error" => "{$e->getMessage()}",
            ], $e->getCode() ? $e->getCode() : 500);
        }
    }


}