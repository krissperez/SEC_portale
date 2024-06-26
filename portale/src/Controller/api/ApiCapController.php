<?php

namespace App\Controller\api;

use App\Entity\Cap;
use App\Helper\SessionHandler;
use App\Repository\AgentiCapRepository;
use App\Repository\CapRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiCapController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    #[Route('/api/cap/liberi', name: 'aggiungi_agenti', methods: ['GET'])]
    public function setAgenti(CapRepository $capRepository): Response{
        SessionHandler::controlSession();
        $capLiberi = $capRepository->capLiberi();

        return $this->json( ['cap_liberi' => $capLiberi]);
    }

    #[Route('/api/cap/comuneProviciaByCap/{cap}', name: "prendi_comuneProvinciaByCap", methods: ["GET"])]
    public  function getComuneProvinciaByCap(ManagerRegistry $doctrine, CapRepository $capRepository, Request $request, string $cap): Response{
        try {
            if (empty($cap)) {
                throw new \Exception("Parametro 'CAP' mancante.", 400);
            }

            $capRepo = $doctrine->getRepository(Cap::class);
            $data = $capRepo->findOneBy(['codice' => $cap]);

            if($data === null){
                throw new \Exception("Parametro 'CAP' non trovato.", 400);
            }

            $newData = $capRepository->getComuneProvinciaByCap($cap);

            return $this->json([
                'ok' => true,
                'message' => "Comune e provincia in base al cap inserito",
                'data' => $newData
            ]);



        }catch (\Exception $e){
            return $this->json([
                'ok' => false,
                "error" => "{$e->getMessage()}",
            ], $e->getCode() ? $e->getCode() : 500);
        }
    }

}