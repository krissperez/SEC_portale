<?php

namespace App\Controller\api;

use App\Repository\ClientiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiAnalisiController extends AbstractController
{
    private EntityManagerInterface $em;
    private ClientiRepository $repoClient;
    public function __construct(EntityManagerInterface $em, ClientiRepository $repoClient){
        $this->em = $em;
        $this->repoClient = $repoClient;
    }

    #[Route('/api/analisi', name: "mostra_analisi_client", methods: ["GET"])]
    public function getAnalysisClient(): Response
    {
        try {
            $data = $this->repoClient->getClientDistributionByAgent();
            return $this->json([
                'ok' => true,
                'data' => $data,
            ], 200);
        }catch (\Exception $e){
            return $this->json([
                'ok' => false,
                'message' => $e->getMessage(),
            ], !    empty($e->getCode()) ? $e->getCode() : 500);
        }

    }
}