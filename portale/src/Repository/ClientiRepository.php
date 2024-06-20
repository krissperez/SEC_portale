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
             WITH a.id = c.id_agente'
        );

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
