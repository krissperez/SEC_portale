<?php

namespace App\Repository;

use App\Entity\AgentiCap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AgentiCap>
 *
 * @method AgentiCap|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgentiCap|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgentiCap[]    findAll()
 * @method AgentiCap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgentiCapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgentiCap::class);
    }

    /**
     * @throws Exception
     */
    public function getRankAgentWithMostCap(int $rank): array
    {
        $em = $this->getEntityManager();
        $connection = $em->getConnection();

        $sql = "
        SELECT a.id, a.nome, a.cognome, COUNT(c.id_agente) AS num_agenti
        FROM agenti a
        INNER JOIN clienti c ON c.id_agente = a.id
        WHERE a.deleted_at IS NULL AND c.deleted_at IS NULL
        GROUP BY a.id, a.nome, a.cognome
        HAVING COUNT(c.id_agente) >= (
            SELECT MIN(num_agenti) FROM (
                SELECT COUNT(c2.id_agente) AS num_agenti
                FROM agenti a2
                INNER JOIN clienti c2 ON c2.id_agente = a2.id
                WHERE a2.deleted_at IS NULL AND c2.deleted_at IS NULL
                GROUP BY a2.id, a2.nome, a2.cognome
                ORDER BY num_agenti DESC
                LIMIT $rank
            ) AS subquery
        )
        ORDER BY num_agenti DESC;
    ";

        $stmt = $connection->executeQuery($sql);
        return $stmt->fetchAllAssociative();

    }

    public function getAgentByCap(string $cap)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT a.id, a.nome, a.cognome, ac.codice_cap
                               FROM App\Entity\Agenti a
                               LEFT JOIN App\Entity\AgentiCap ac
                               WITH ac.id_agente = a.id
                               WHERE ac.codice_cap = :cap")
            ->setParameter('cap', $cap);

        return $query->getResult();
    }
//    /**
//     * @return AgentiCap[] Returns an array of AgentiCap objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AgentiCap
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
