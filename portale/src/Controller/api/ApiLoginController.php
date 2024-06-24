<?php

namespace App\Controller\api;

use App\Entity\Utenti;
use App\Helper\Validator;
use App\Repository\UtentiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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
                throw new \Exception('Errore nell\' invio dei dati', 422);
            }

            $user = $this->utentiRepository->findByUsernameAndPassword($username, $password);
            if (!$user) {
                throw new \Exception("Credenziali Errate", 422);
            }

            $token = $this->utentiRepository->findOneBy(['username' => $username]);
            session_start();
            if(!empty($token) && !empty($token->getId())){
                $_SESSION['loggedUserId'] = $token->getId();
            }
            return $this->json([
                'ok' => true,
                'data' => $user
            ]);

        } catch (\Exception $e){
            return $this->json(
                [
                    'ok' => false,
                    'error' => "{$e->getMessage()} in line {$e->getLine()}",
                    'userMessage' => $e->getMessage()

                ]
                , $e->getCode() ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

    }

    #[Route('/api/register', name: "register", methods: ["POST"])]
    public function registerUser(ManagerRegistry $doctrine,Request $request): Response
    {
        try {
            $email = $request->request->get('email');
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            $cPassword = $request->request->get('cPassword');

            if (empty($email) || empty($username) || empty($password) || empty($cPassword)) {
                throw new \Exception('Tutti i campi sono obbligatori', 422);
            }

            $entityManager = $doctrine->getManager();

            $user = new Utenti();
            $user->setEmail($email);
            $user->setUsername($username);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

//
//            // tell Doctrine you want to (eventually) save the Product (no queries yet)
//            $entityManager->persist($product);
//
//            // actually executes the queries (i.e. the INSERT query)
//            $entityManager->flush();
//
//            if (empty($username) || empty($password)) {
//                throw new \Exception('Errore nell\' invio dei dati', 422);
//            }
//
//            $user = $this->utentiRepository->findByUsernameAndPassword($username, $password);
//            if (!$user) {
//                throw new \Exception("Credenziali Errate", 422);
//            }
//
//            $token = $this->utentiRepository->findOneBy(['username' => $username]);
//            session_start();
//            if(!empty($token) && !empty($token->getId())){
//                $_SESSION['loggedUserId'] = $token->getId();
//            }
//            return $this->json([
//                'ok' => true,
//                'data' => $user
//            ]);

        } catch (\Exception $e){
            return $this->json(
                [
                    'ok' => false,
                    'error' => "{$e->getMessage()} in line {$e->getLine()}",
                    'userMessage' => $e->getMessage()

                ]
                , $e->getCode() ? $e->getCode() : Response::HTTP_BAD_REQUEST);
        }

    }

    #[Route('/logout', name: 'logout')]
    public function logout(): Response
    {
        session_start(); // Avvia la sessione, se non è già stata avviata
        unset($_SESSION['loggedUserId']); // Rimuovi la variabile di sessione

        // Reindirizza l'utente alla pagina di login o a un'altra pagina appropriata
        return $this->redirectToRoute('pagina_login');
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