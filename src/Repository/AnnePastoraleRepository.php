<?php

namespace App\Repository;

use App\Entity\AnnePastorale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AnnePastorale|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnnePastorale|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnnePastorale[]    findAll()
 * @method AnnePastorale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnePastoraleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnnePastorale::class);
    }

    // /**
    //  * @return AnnePastorale[] Returns an array of AnnePastorale objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnnePastorale
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
