<?php

namespace App\Controller\api;

use App\Entity\Utenti;
use App\Helper\Validator;
use App\Repository\UtentiRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function loginUser(ManagerRegistry $doctrine, Request $request): Response
    {
        try {
            $username = trim($request->request->get('username'));
            $password = trim($request->request->get('password'));

            if (empty($username) || empty($password)) {
                throw new \Exception('Tutti i campi sono obbligatori', 422);
            }

            $entityManager = $doctrine->getManager();
            $user = $entityManager->getRepository(Utenti::class)->findOneBy(['username' => $username]);

            if (!$user) {
                throw new \Exception('Utente non trovato', 404);
            }

            if (!password_verify($password, $user->getPassword())) {
                throw new \Exception('Password non corretta', 401);
            }

            if(session_status() === PHP_SESSION_ACTIVE){
                session_destroy();

            }


            ini_set('session.gc_maxlifetime', 21600);       // 21600 secondi = 6 ore
            ini_set('session.cookie_lifetime', 0);          // Cookie di sessione scade alla chiusura del browser
            session_start();
            $_SESSION['loggedUserId'] = $user->getId();

            return $this->json([
                'ok' => true,
                'message' => 'Login effettuato con successo',
                'data' => [
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail()
                ]
            ]);

        } catch (\Exception $e) {
            return $this->json(
                [
                    'ok' => false,
                    'error' => "{$e->getMessage()} in line {$e->getLine()}",
                    'userMessage' => $e->getMessage()
                ],
                $e->getCode() ? $e->getCode() : Response::HTTP_BAD_REQUEST
            );
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

            if (empty($email) ||
                empty($username) ||
                empty($password) ||
                empty($cPassword)) {
                throw new \Exception('Tutti i campi sono obbligatori', 422);
            }

            if ($password !== $cPassword) {
                throw new \Exception('Le password non corrispondono', 422);
            }

            if ($this->utentiRepository->findOneBy(['email' => $email])) {
                throw new \Exception('Email già utilizzata', 409);
            }

            if ($this->utentiRepository->findOneBy(['username' => $username])) {
                throw new \Exception('Username già utilizzato', 409);
            }

            $entityManager = $doctrine->getManager();
            $user = new Utenti();
            $user->setEmail($email);
            $user->setUsername($username);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

            $entityManager->persist($user);
            $entityManager->flush();


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

    #[Route('/logout', name: 'logout')]
    public function logout(): Response
    {
        session_start(); // Avvia la sessione, se non è già stata avviata
        unset($_SESSION['loggedUserId']); // Rimuovi la variabile di sessione
        session_destroy();
        // Reindirizza l'utente alla pagina di login o a un'altra pagina appropriata
        return $this->redirectToRoute('pagina_login');
    }

    #[Route('/api/forgotPwd', name: "forgotPassword", methods: ["POST"])]
    public function setNewPwd(ManagerRegistry $doctrine,Request $request): Response
    {
        try {
            $username = $request->request->get('username');
            $newPassword = $request->request->get('newPassword');
            $cNewPassword = $request->request->get('cNewPassword');

            if (empty($username) ||
                empty($newPassword) ||
                empty($cNewPassword)) {
                throw new \Exception('Tutti i campi sono obbligatori', 422);
            }

            if ($newPassword !== $cNewPassword) {
                throw new \Exception('Le password non corrispondono', 422);
            }

            $user = $this->utentiRepository->findOneBy(['username' => $username]);

            if (!$user) {
                throw new \Exception('Username non esistente', 409);
            }

            $entityManager = $doctrine->getManager();
            $user->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));

            $entityManager->persist($user);
            $entityManager->flush();

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

}






