<?php

namespace App\Repository;

use App\Entity\Agenti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Agenti>
 *
 * @method Agenti|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agenti|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agenti[]    findAll()
 * @method Agenti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgentiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agenti::class);
    }


    public function findAgentsWhitCap(){

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('nome', 'nome');
        $rsm->addScalarResult('cognome', 'cognome');
        $rsm->addScalarResult('codice_cap', 'codice_cap');

        $sql = "
            SELECT 
                a.id, 
                a.nome, 
                a.cognome, 
                GROUP_CONCAT(ac.codice_cap ORDER BY ac.codice_cap ASC SEPARATOR ',') AS codice_cap
            FROM 
                agenti a
            LEFT JOIN 
                agenti_cap ac ON ac.id_agente = a.id
            WHERE 
                a.deleted_at IS NULL
            GROUP BY 
                a.id, a.nome, a.cognome
        ";

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }


    public function getAmountAgents()
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(

            'SELECT COUNT(A.id) AS total
             FROM App\Entity\Agenti AS A
             WHERE A.deleted_at IS NULL'
        );

        return $query->getSingleScalarResult();
    }


//    /**
//     * @return Agenti[] Returns an array of Agenti objects
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

//    public function findOneBySomeField($value): ?Agenti
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
