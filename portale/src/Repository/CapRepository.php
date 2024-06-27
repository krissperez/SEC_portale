<?php

namespace App\Repository;

use App\Entity\Cap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cap>
 *
 * @method Cap|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cap|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cap[]    findAll()
 * @method Cap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cap::class);
    }
    public function capLiberi(){
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            /*'SELECT c.codice
                FROM App\Entity\Cap AS c
                LEFT JOIN App\Entity\AgentiCap AS ac
                WITH c.codice = ac.codice_cap
                WHERE ac.codice_cap IS NULL'*/
            'SELECT *
                FROM App\Entity\Cap c
                WHERE c.codice NOT IN (SELECT ac.codice_cap FROM App\Entity\AgentiCap ac) ;'
        );
        return $query->getResult();
    }

    public function getComuneProvinciaByCap(string $cap){
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT c.codice, c.comune, p.nome AS provincia
                               FROM App\Entity\Cap c
                               LEFT JOIN App\Entity\Province p
                               WITH p.sigla=c.sigla_provincia
                               WHERE c.codice = :cap")
            ->setParameter('cap', $cap);

        return $query->getResult();
    }

//    /**
//     * @return Cap[] Returns an array of Cap objects
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

//    public function findOneBySomeField($value): ?Cap
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
