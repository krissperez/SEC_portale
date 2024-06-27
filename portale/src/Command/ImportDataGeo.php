<?php

namespace App\Command;

use App\db\AllProvinces;
use App\Entity\Cap;
use App\Entity\Province;
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
class ImportDataGeo extends Command
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
        $entityOption = ['province', 'cap'];
        $urlProvinces = "https://axqvoqvbfjpaamphztgd.functions.supabase.co/province";
        $urlCap = "https://raw.githubusercontent.com/matteocontrini/comuni-json/master/comuni.json";

        if(!in_array($entity, $entityOption)){
            $output->writeln("<error>Entity $entity does not exist </error>");
            return Command::FAILURE;
        }

        try{

            $output->writeln("<info>Importing {$entity} data...</info>");

            if($entity === 'province'){
                $this->saveProvinceInDB($urlProvinces, $output);
            }elseif ($entity === 'cap'){
                $this->saveCapDb($urlCap, $output);
            }else {
                $output->writeln("<error>Entity $entity does not exist </error>");
                return Command::FAILURE;
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
        global $arrProvinces;
        $dataProvinces = $this->httpGetData(
            "GET",
            $url,
            $output);


        foreach (AllProvinces::$arrProvinces as $p) {
            $province = new Province();
            $province->setNome($p['nome']);
            $province->setSigla($p['sigla']);
            $this->em->persist($province);
        }

        $this->em->flush();
    }

    private function saveCapDb(string $url, OutputInterface $output)
    {
        $dataCap = $this->httpGetData(
            "GET",
            $url,
            $output);
        foreach ($dataCap as $data) {
            $allCap = $data['cap'];
            foreach ($allCap as $cap) {
                $capEntity = new Cap();
                $capEntity->setComune($data['nome']);
                $capEntity->setSiglaProvincia($data['sigla']);
                $capEntity->setCodice($cap);
                $this->em->persist($capEntity);

            }
        }

        $this->em->flush();
    }
}