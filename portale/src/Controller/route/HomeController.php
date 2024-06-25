<?php

namespace App\Controller\route;

use App\Helper\SessionHandler;
use App\Repository\AgentiCapRepository;
use App\Repository\AgentiRepository;
use App\Repository\ClientiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class HomeController extends AbstractController
{
    private EntityManagerInterface $em;
    private ClientiRepository $repoClient;
    private AgentiRepository $repoAgent;
    private AgentiCapRepository $repoAgentCap;
    public function __construct(EntityManagerInterface $em, ClientiRepository $repoClient, AgentiRepository $repoAgent, AgentiCapRepository $repoAgentCap)
    {
        $this->em = $em;
        $this->repoClient = $repoClient;
        $this->repoAgent = $repoAgent;
        $this->repoAgentCap = $repoAgentCap;
    }


    #[Route('/', name: 'home')]
    public function home(LoggerInterface $logger): Response
    {
        SessionHandler::controlSession();

        try {

            $clientTotal = $this->repoClient->getAmountClients();
            $salesLastThreeMonths = $this->repoClient->getSalesByDateRange("-3 months");
            $agentTotal = $this->repoAgent->getAmountAgents();
            $topFiveAgents = $this->repoAgentCap->getRankAgentWithMostCap(5);


            return $this->render('home/home.html.twig', [
                'clientTotal' => $clientTotal,
                'agentTotal' => $agentTotal,
                "salesLastThreeMonths" => $salesLastThreeMonths,
                "topFiveAgents" => $topFiveAgents,
            ]);

        } catch (\Exception $e) {
            $logger->error('An error occurred: ' . $e->getMessage());
            $this->addFlash('error', 'An unexpected error occurred. Please try again later.');
            return $this->redirectToRoute('error_page', ['error_message' => $e->getMessage()]);
        }
    }



}