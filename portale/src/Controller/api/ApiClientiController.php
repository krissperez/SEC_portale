<?php

namespace App\Controller\api;

use App\Entity\Cap;
use App\Entity\Clienti;
use App\Entity\Province;
use App\Helper\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiClientiController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    #[Route('/api/clienti', name: "createCliente", methods: ["POST"])]
    public function createClient (Request $request) : Response
    {
        try{
            $repoClient = $this->em->getRepository(Clienti::class)->findAll();
            $data = $request->toArray();

            if(empty($data['ragione_sociale'])
                || empty($data["partita_iva"])
                || empty($data["indirizzo"])
                || empty($data["provincia"])
                || empty($data["email"])
                || empty($data["pec"])
                || empty($data["telefono"])
                || empty($data["settore_attivita"])
                || empty($data["id_agente"])
                || empty($data['data_acquisizione']))
            {
                throw new \Exception("All fields are required", 422);
            }

            if(!Validator::validateEmail($data['email'])){
                throw new \Exception("Invalid email", 422);
            }

            if(!Validator::validatePartitaIva($data['partita_iva'])){
                throw new \Exception("Invalid partita iva", 422);
            }

            if(!Validator::validateCap($data['cap'])){
                throw new \Exception("Invalid cap", 422);
            }

            if(!Validator::validatePec($data['pec'])){
                throw new \Exception("Invalid pec", 422);
            }

            if(!Validator::validatePhoneNumber($data['telefono'])){
                throw new \Exception("Invalid phone number", 422);
            }

            if(!Validator::validateDate($data['data_acquisizione'])){
                throw new \Exception("Invalid date", 422);
            }


            $cliente = new Clienti();
            $cliente->setRagioneSociale($data['ragione_sociale']);
            $cliente->setPartitaIva($data['partita_iva']);
            $cliente->setIndirizzo($data['indirizzo']);
            $cliente->setProvincia($data['provincia']);
            $cliente->setEmail($data['email']);
            $cliente->setTelefono($data['telefono']);
            $cliente->setSettoreAttivita($data['settore_attivita']);
            $cliente->setIdAgente($data['id_agente']);
            $cliente->setDataAcquisizione(new \DateTime($data['data_acquisizione']));
            $cliente->setCap($data['cap']);
            $cliente->setPec($data['pec']);

            $this->em->persist($cliente);
            $this->em->flush();




            return $this->json($data);
        }catch(\Exception $e){
            return $this->json(
                [
                    'ok' => false,
                    "error" => "{$e->getMessage()} in line {$e->getLine()}"
                ]
                , Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}