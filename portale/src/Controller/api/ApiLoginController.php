<?php

namespace App\Controller\api;

use App\Helper\Validator;
use App\Repository\UtentiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiLoginController extends AbstractController
{
    private UtentiRepository $utentiRepository;

    public function __construct(UtentiRepository $utentiRepository)
    {
        $this->utentiRepository = $utentiRepository;;
    }

    #[Route('/api/login', name: "login", methods: ["POST"])]
    public function checkCredentials(Request $request): Response
    {
        try {
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            if (empty($username) || empty($password)) {
                throw new \Exception("Errore nell invio dei dati", 422);
            }

            $user = $this->utentiRepository->findByUsernameAndPassword($username, $password);

            if (!$user) {
                throw new \Exception("Credenziali Errate", 422);
            }
            //$this->redirectToRoute('mostra_clienti');
            return $this->json([
                'ok' => true,
                'data' => $user
            ]);

        }catch(\Exception $e){
            return $this->json(
                [
                    'ok' => false,
                    "error" => "{$e->getMessage()} in line {$e->getLine()}",

                ]
                , $e->getCode());
        }

    }
}








//#[Route('/api/login', name: "login", methods: ["POST"])]
//public function checkCredentials(Request $request): Response
//{
//    $username = $request->request->get('username');
//    $password = $request->request->get('password');
//
//    if (!empty($username) && !empty($password)) {
//        // Check credentials (this is a placeholder, implement actual authentication logic)
//        if ($this->authenticate($username, $password)) {
//            return $this->redirectToRoute('mostra_clienti');
//        }
//        // Authentication failed
//        $this->addFlash('error', 'Invalid username or password');
//    } else {
//        $this->addFlash('error', 'Both fields are required');
//    }
//
//    return $this->redirectToRoute('login');
//}
//
//private function authenticate($username, $password)
//{
//    // Implement actual authentication logic, e.g., check against a database
//    // This is a placeholder and should be replaced with real authentication
//    return $username === 'admin' && $password === 'password';
//}