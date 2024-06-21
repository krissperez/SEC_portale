<?php

namespace App\Controller\api;

use App\Helper\Validator;
use App\Repository\UtentiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiLoginController extends AbstractController
{
    private UtentiRepository $utentiRepository;

    public function __construct(UtentiRepository $utentiRepository){
        $this->utentiRepository = $utentiRepository;;
    }

    #[Route('/api/login', name: "login", methods: ["POST"])]
    public function checkCredentials(Request $request): Response
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        if (!empty($username) && !empty($password)) {
            $user = $this->utentiRepository->findByUsernameAndPassword($username, $password);

            if ($user !== null) {
                // User found, redirect to mostra_clienti
                return $this->redirectToRoute('mostra_clienti');
            } else {
                // User not found, redirect to login page
                return $this->redirectToRoute('pagina_login');
            }
        }

        // If username or password is empty, redirect to login page
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