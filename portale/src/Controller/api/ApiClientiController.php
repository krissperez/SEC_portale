<?php

namespace App\Controller\api;

use App\Entity\Agenti;
use App\Entity\AgentiCap;
use App\Entity\Cap;
use App\Entity\Clienti;
use App\Entity\Province;
use App\Helper\SessionHandler;
use App\Helper\Validator;
use Doctrine\ORM\EntityManagerInterface;
use http\Client;
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
    #[Route('/api/clients', name: "crea_cliente", methods: ["POST"])]
    public function createClient (Request $request) : Response
    {
        try{

            $repo = $this->em->getRepository(Agenti::class);
            $data = json_decode($request->getContent(), true);


            $ragione_sociale = trim($data['ragione_sociale']);
            $partita_iva = trim($data['partita_iva']);
            $indirizzo = trim($data['indirizzo']);
            $provincia = trim($data['provincia']);
            $email = trim($data['email']);
            $pec = trim($data['pec']);
            $telefono =trim($data['telefono']);
            $settore_attivita = trim($data['settore_attivita']);
            $id_agente = $data['id_agente'];
            $data_acquisizione = trim($data['data_acquisizione']);
            $cap = trim($data['cap']);


            if(empty($ragione_sociale)
                || empty($partita_iva)
                || empty($indirizzo)
                || empty($provincia)
                || empty($email)
                || empty($pec)
                || empty($telefono)
                || empty($settore_attivita)
                || empty($id_agente)
                || empty($data_acquisizione))
            {
                throw new \Exception("Tutti campi sono obbligatori", 422);
            }

            $agent = $repo->findOneBy(['id' => $id_agente, 'deleted_at' => null]);

            if(empty($agent)){
                throw new \Exception("Scegliere un agente da assegnare", 422);
            }

            if(!Validator::validateEmail($email)){
                throw new \Exception("Email non valido", 422);
            }

            if(!Validator::validatePartitaIva($partita_iva)){
                throw new \Exception("Partita Iva non valido", 422);
            }

            if(!Validator::validateCap($cap)){
                throw new \Exception("Cap non valido", 422);
            }

            if(!Validator::validatePec($pec)){
                throw new \Exception("Pec non valido", 422);
            }

            if(!Validator::validatePhoneNumber($telefono)){
                throw new \Exception("Telefono non valido", 422);
            }

            if(!Validator::validateDate($data_acquisizione)){
                throw new \Exception("Data non valido", 422);
            }

            if(!Validator::validateField($ragione_sociale)){
                throw new \Exception("La ragione sociale non è valida", 422);
            }

            if(!Validator::validateField($settore_attivita)){
                throw new \Exception("Il settore attività non è valido", 422);
            }

            if(!Validator::validateField($indirizzo)){
                throw new \Exception("L'indirizzo non è valido", 422);
            }

            $client = new Clienti();
            $client->setRagioneSociale($ragione_sociale);
            $client->setPartitaIva($partita_iva);
            $client->setIndirizzo($indirizzo);
            $client->setProvincia($provincia);
            $client->setEmail($email);
            $client->setTelefono($telefono);
            $client->setSettoreAttivita($settore_attivita);
            $client->setIdAgente($id_agente);
            $client->setDataAcquisizione(new \DateTime($data_acquisizione));
            $client->setCap($cap);
            $client->setPec($pec);


            $agentiCapRepository = $this->em->getRepository(AgentiCap::class);
            $checkAgentiCap = $agentiCapRepository->findOneBy(['codice_cap' => $cap, 'deleted_at' => null]);

            if ($checkAgentiCap === null) {
                $relazioneAgentiCap = new AgentiCap();
                $relazioneAgentiCap->setIdAgente($id_agente);
                $relazioneAgentiCap->setIdCap($cap);
                $this->em->persist($relazioneAgentiCap);
            }

            $this->em->persist($client);
            $this->em->flush();

            return $this->json([
                'ok' => true,
                'message' => 'Cliente creato',
                'id' => $client->getId()
            ], 200);

        }catch(\Exception $e){
            return $this->json(
                [
                    'ok' => false,
                    "error" => "{$e->getMessage()}",
                    "userMessage" => $e->getMessage()
                ]
                , $e->getCode());
        }

    }

    #[Route('/api/clients', name: "prendi_clienti", methods: ["GET"])]
    public function getAllClients (Request $request) : Response
    {
        try{
            $repo = $this->em->getRepository(Clienti::class);
            $allClients = $repo->findBy(['deleted_at' => null]);

            return $this->json([
                'ok' => true,
                'message' => "clients",
                'data' => $allClients
            ]);

        }catch (\Exception $e){
            return $this->json([
                'ok' => false,
                "error" => "{$e->getMessage()}",
            ], $e->getCode());
        }
    }

    #[Route('/api/clients/{id}', name: "prendi_cliente", methods: ["GET"])]
    public function getClient (int $id) : Response
    {
        try{
            $repo = $this->em->getRepository(Clienti::class);

            $client = $repo->findOneBy(['deleted_at' => null, 'id' => $id]);

            if(empty($client)){
                throw new \Exception("Cliente non trovato", 422);
            }

            return $this->json([
                'ok' => true,
                'message' => "client",
                'data' => $client
            ]);

        }catch (\Exception $e){
            return $this->json([
                'ok' => false,
                "error" => "{$e->getMessage()}",
            ], $e->getCode());
        }
    }

    #[Route('/api/clients/{id}', name: "cancella_cliente", methods: ["DELETE"])]
    public function deleteClient (int $id) : Response
    {
        try{
            $repo = $this->em->getRepository(Clienti::class);

            /**@var Clienti $client*/
            $client = $repo->findOneBy(['deleted_at' => null, 'id' => $id]);

            if(empty($client)){
                throw new \Exception("Cliente non trovato", 422);
            }

            $curDate = new \DateTime();
            $client->setDeletedAt($curDate);

            $this->em->persist($client);
            $this->em->flush();

            return $this->json([
                'ok' => true,
                'message' => "cliente id:$id eliminato",
            ]);

        }catch (\Exception $e){
            return $this->json([
                'ok' => false,
                "error" => "{$e->getMessage()}",
            ], $e->getCode() ?: 400); // Default to 400 if no specific error code is set
        }
    }

    #[Route('/api/clients/{id}', name: "modifica_clienteAPI", methods: ["PUT"])]
    public function editClient (Request $request, $id) : Response
    {
        try{
            $repoClient = $this->em->getRepository(Clienti::class);
            $data = $request->toArray();

            /**@var Clienti $client*/
            $client = $repoClient->findOneBy(['deleted_at' => null, 'id' => $id]);

            if(empty($client)){
                throw new \Exception("Cliente non trovato", 422);
            }


            $ragione_sociale = isset($data['ragione_sociale']) ? trim($data['ragione_sociale']) : $client->getRagioneSociale();
            $partita_iva = isset($data['partita_iva']) ? trim($data['partita_iva']) : $client->getPartitaIva();
            $indirizzo = isset($data['indirizzo']) ? trim($data['indirizzo']) : $client->getIndirizzo();
            $provincia = isset($data['provincia']) ? trim($data['provincia']) : $client->getProvincia();
            $email = isset($data['email']) ? trim($data['email']) : $client->getEmail();
            $telefono = isset($data['telefono']) ? trim($data['telefono']) : $client->getTelefono();
            $data_acquisizione = isset($data['data_acquisizione']) ? new \DateTime($data['data_acquisizione']) : $client->getDataAcquisizione();
            $cap = isset($data['cap']) ? trim($data['cap']) : $client->getCap();
            $pec = isset($data['pec']) ? trim($data['pec']) : $client->getPec();
            $settore_attivita = isset($data['settore_attivita']) ? (trim($data['settore_attivita']) ): $client->getSettoreAttivita();
            $id_agente = isset($data['id_agente']) ? trim($data['id_agente']) : $client->getIdAgente();

            if ($id_agente !== '' && !is_numeric($id_agente)) {
                throw new \Exception("Scegliere un agente da assegnare");
            }

            $client->setRagioneSociale($ragione_sociale);
            $client->setPartitaIVA($partita_iva);
            $client->setIndirizzo($indirizzo);
            $client->setProvincia($provincia);
            $client->setEmail($email);
            $client->setTelefono($telefono);
            $client->setDataAcquisizione($data_acquisizione);
            $client->setCap($cap);
            $client->setPec($pec);
            $client->setSettoreAttivita($settore_attivita);
            $client->setIdAgente($id_agente);


            $repoAgent = $this->em->getRepository(Agenti::class);
            $agent = $repoAgent->findOneBy(['id' => $client->getIdAgente(), 'deleted_at' => null]);

            if(empty($agent)){
                throw new \Exception("Agente non trovato", 422);
            }

            if(!Validator::validateEmail($client->getEmail())){
                throw new \Exception("Email invalido", 422);
            }

            if(!Validator::validatePartitaIva($client->getPartitaIva())){
                throw new \Exception("Partita Iva invalido", 422);
            }

            if(!Validator::validateCap($client->getCap())){
                throw new \Exception("Cap invalido", 422);
            }

            if(!Validator::validatePec($client->getPec())){
                throw new \Exception("Pec invalido", 422);
            }

            if(!Validator::validatePhoneNumber($client->getTelefono())){
                throw new \Exception("Invalid phone number", 422);
            }

            if(!Validator::validateField($ragione_sociale)){
                throw new \Exception("La ragione sociale non è valida", 422);
            }

            if(!Validator::validateField($settore_attivita)){
                throw new \Exception("Il settore attività non è valido", 422);
            }

            if(!Validator::validateField($indirizzo)){
                throw new \Exception("L'indirizzo non è valido", 422);
            }

            $agentiCapRepository = $this->em->getRepository(AgentiCap::class);
            $checkAgentiCap = $agentiCapRepository->findOneBy(['codice_cap' => $cap, 'deleted_at' => null]);

            if ($checkAgentiCap === null) {
                $relazioneAgentiCap = new AgentiCap();
                $relazioneAgentiCap->setIdAgente($id_agente);
                $relazioneAgentiCap->setIdCap($cap);
                $this->em->persist($relazioneAgentiCap);
            }

            $this->em->persist($client);
            $this->em->flush();

            return $this->json([
                'ok' => true,
                'message' => "Client modificato",
                'data' => $client
            ]);

        }catch (\Exception $e){
            return $this->json([
                'ok' => false,
                "error" => "{$e->getMessage()} in line {$e->getLine()}",
                "userMessage" => $e->getMessage()
            ], 500);
        }
    }

}

