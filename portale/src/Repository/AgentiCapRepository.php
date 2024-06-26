<?php

namespace App\Repository;

use App\Entity\AgentiCap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function getRankAgentWithMostCap(int $rank)
    {
        $em = $this->getEntityManager();

        $maxAgentsQuery = $em->createQuery("
    SELECT COUNT(ac2.id_agente) AS agentCount
    FROM App\Entity\AgentiCap ac2
    LEFT JOIN App\Entity\Agenti a2 WITH ac2.id_agente = a2.id
    WHERE a2.deleted_at IS NULL
    GROUP BY ac2.id_agente
    ORDER BY agentCount DESC
");

        $maxAgentsQuery->setMaxResults(1)->setFirstResult($rank);

        $maxAgents = $maxAgentsQuery->getSingleScalarResult();

        $query = $em->createQuery("
    SELECT COUNT(ac.id_agente) AS num_agenti, a.nome, a.cognome
    FROM App\Entity\AgentiCap ac
    LEFT JOIN App\Entity\Agenti a WITH ac.id_agente = a.id
    LEFT JOIN App\Entity\Cap c WITH ac.codice_cap = c.codice
    WHERE a.deleted_at IS NULL
    GROUP BY ac.id_agente, a.nome, a.cognome
    HAVING COUNT(ac.id_agente) >= :maxAgents
    ORDER BY num_agenti DESC
");

        $query->setParameter('maxAgents', $maxAgents);

        return $query->getResult();


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
