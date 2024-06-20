<?php

namespace App\Command;

use App\Entity\Provinces;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

#[AsCommand(
    name: 'app:import-geo-data',
    description: 'import all geographical data.',
    aliases: ['app:import-data-geographical'],
    hidden: false
)]
class ImportDataGeo
{
    private EntityManager $em;


    public function __construct(EntityManagerInterface $entityManager){
        $this->em = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('entity', InputArgument::REQUIRED, 'what entity populate')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {



        $entity = $input->getArgument('entity');
        $entityOption = ['provinces', 'cap'];
        $urlProvinces = "https://axqvoqvbfjpaamphztgd.functions.supabase.co/province";
        $urlCap = "";

        if(!in_array($entity, $entityOption)){
            $output->writeln("<error>Entity $entity does not exist </error>");
            return Command::FAILURE;
        }

        try{

            $output->writeln("<info>Importing {$entity} data...</info>");

            if($entity === 'provinces'){
                $this->saveProvinceInDB($urlProvinces, $output);
            }elseif ($entity === 'cap'){
                $this->saveProvinceInDB($urlCap, $output);
            }


            $output->writeln("<info>All {$entity} have been imported.</info>");


            return Command::SUCCESS;


        }catch (\Exception $e){
            $output->writeln("<error>{$e->getMessage()} in line {$e->getLine()}</error>");
            return Command::FAILURE;
        }




    }

    private function httpGetData(string $method, string $url, OutputInterface $output): array{
        try{
            $client = HttpClient::create();
            $response = $client->request($method, $url);

            if($response->getStatusCode() != 200){
                throw new \Exception("Something went wrong importing geographical data.");
            }

            return $response->toArray();
        }catch(\Exception $e){
            $output->writeln("<error>{$e->getMessage()} in line {$e->getLine()}</error>");
            return [
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

    private function saveProvinceInDB(string $url, OutputInterface $output): void
    {
        $dataProvinces = $this->httpGetData(
            "GET",
            $url,
            $output);

        foreach ($dataProvinces as $p) {
            $province = new Provinces();
            $province->setNome($p['nome']);
            $province->setSigla($p['sigla']);
            $province->setCodice($p['codice']);

            $this->em->persist($province);
        }

        $this->em->flush();
    }
}