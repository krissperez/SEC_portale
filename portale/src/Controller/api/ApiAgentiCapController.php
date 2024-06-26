<?php

namespace App\Controller\api;

use App\Entity\Agenti;
use App\Entity\AgentiCap;
use App\Repository\AgentiCapRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiAgentiCapController extends AbstractController
{
    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    #[Route('/api/agentsCap/agentsByCap/{cap}', name: "prendi_agenteByCap", methods: ["GET"])]
    public function getAgentByCap(ManagerRegistry $doctrine, AgentiCapRepository $agentiCapRepository, Request $request, string $cap) : Response {
        try {
            if (empty($cap)) {
                return $this->json([
                    'ok' => false,
                    'message' => "Parametro 'cap' mancante",
                ], 400);
            }

            $res1 = $agentiCapRepository->getAgentByCap($cap);
            if(!empty($res1)){
                return $this->json([
                    'ok' => true,
                    'message' => "agente trovato",
                    'data' => $res1
                ], 200);
            }

            $res2 = $doctrine->getRepository(Agenti::class)->findBy(["deleted_at" => null]);


            return $this->json([
                'ok' => true,
                'message' => "lista agenti",
                'data' => $res2
            ], 200);


        }catch (\Exception $e){
            return $this->json([
                'ok' => false,
                "error" => "{$e->getMessage()}",
            ], $e->getCode() ? $e->getCode() : 500);
        }
    }

    #[Route('api/createAgentiCap', name: "createAgentiCap", methods: ["POST"])]
    public function createAgentiCap(ManagerRegistry $doctrine, Request $request): Response {
        $data = json_decode($request->getContent(), true);

        $agentiCap = new AgentiCap();
        $agentiCap->setIdCap($data['cap']);
        $agentiCap->setIdAgente($data['id_agente']);

        return $this->json([]);


    }
}