<?php

namespace App\Repository;

use App\Entity\Clienti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Clienti>
 *
 * @method Clienti|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clienti|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clienti[]    findAll()
 * @method Clienti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clienti::class);
    }

    public function findClientsWithAgent()
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT c, CONCAT(a.nome, \' \', a.cognome) AS agente
             FROM App\Entity\Clienti AS c
             LEFT JOIN App\Entity\Agenti AS a
             WITH a.id = c.id_agente
             WHERE c.deleted_at IS NULL'
        );

        return $query->getResult();
    }

    public function getAmountClients()
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT COUNT(c.id) AS total
             FROM App\Entity\Clienti AS c
             WHERE c.deleted_at IS NULL'
        );

        return $query->getSingleScalarResult();
    }

    /**
     * @throws \Exception
     */
    public function getSalesByDateRange(string $date)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT COUNT(c.id) AS total
             FROM App\Entity\Clienti c
             WHERE c.deleted_at IS NULL AND c.data_acquisizione >= :time'
        )->setParameter('time', new \DateTime($date));

        return $query->getSingleScalarResult();
    }


    public function getClientDistributionByAgent()
    {
        $em = $this->getEntityManager();

        // Subquery for total_general
        $totalGeneralQuery = $em->createQuery("
        SELECT COUNT(c.id) AS total
        FROM App\Entity\Clienti c
        INNER JOIN App\Entity\Agenti a WITH c.id_agente = a.id
        WHERE c.deleted_at IS NULL AND a.deleted_at IS NULL
    ");
        $totalGeneral = $totalGeneralQuery->getSingleScalarResult();

        // Main query
        $query = $em->createQuery("
        SELECT
            a.id AS id_agente,
            a.nome,
            a.cognome,
            COUNT(c.id) AS total,
            (COUNT(c.id) * 100.0 / :totalGeneral) AS percent
        FROM App\Entity\Clienti c
        INNER JOIN App\Entity\Agenti a WITH c.id_agente = a.id
        WHERE c.deleted_at IS NULL AND a.deleted_at IS NULL
        GROUP BY a.id, a.nome, a.cognome
    ")->setParameter('totalGeneral', $totalGeneral);


        return $query->getResult();
    }

    /**
     * @throws \Exception
     */
    public function getTotalAgentsWithClientsByTime(string $time)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT 
            a.id,
            a.nome,
            a.cognome,
            (
                SELECT COUNT(c.id)
                FROM App\Entity\Clienti c
                WHERE c.deleted_at IS NULL
                  AND c.data_acquisizione >= :time
                  AND c.id_agente = a.id
            ) AS total_clienti
        FROM App\Entity\Agenti a
        WHERE a.deleted_at IS NULL";

        $query = $em->createQuery($dql);
        $query->setParameter('time', new \DateTime($time));
        return $query->getResult();

    }

    public function getTotalAgentsWithClients()
    {
        $em = $this->getEntityManager();
        $dql = "SELECT 
            a.id,
            a.nome,
            a.cognome,
            cl.data_acquisizione,
            (
                SELECT COUNT(c.id)
                FROM App\Entity\Clienti c
                WHERE c.deleted_at IS NULL
                  AND c.id_agente = a.id
            ) AS total_clienti
        FROM App\Entity\Agenti a
        LEFT JOIN App\Entity\Clienti cl WITH cl.id_agente = a.id
        WHERE a.deleted_at IS NULL";

        $query = $em->createQuery($dql);
        return $query->getResult();

    }

    public function getTotalClientsByTime(string $time)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT 
            a.id,
            a.nome,
            a.cognome,
            cl.data_acquisizione,
            (
                SELECT COUNT(c.id)
                FROM App\Entity\Clienti c
                WHERE c.deleted_at IS NULL
                  AND c.id_agente = a.id
            ) AS total_clienti
        FROM App\Entity\Agenti a
        LEFT JOIN App\Entity\Clienti cl WITH cl.id_agente = a.id
        WHERE a.deleted_at IS NULL";

        $query = $em->createQuery($dql);
        return $query->getResult();

    }







//    /**
//     * @return Clienti[] Returns an array of Clienti objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Clienti
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
