<?php

namespace App\Repository;

use App\Entity\Utenti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Utenti>
 *
 * @method Utenti|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utenti|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utenti[]    findAll()
 * @method Utenti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtentiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utenti::class);
    }

    public function findByUsernameAndPassword($username, $password)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username')
            ->andWhere('u.password = :password')
            ->setParameter('username', $username)
            ->setParameter('password', $password)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Utenti[] Returns an array of Utenti objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Utenti
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
