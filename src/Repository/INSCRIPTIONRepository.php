<?php

namespace App\Repository;

use App\Entity\INSCRIPTION;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method INSCRIPTION|null find($id, $lockMode = null, $lockVersion = null)
 * @method INSCRIPTION|null findOneBy(array $criteria, array $orderBy = null)
 * @method INSCRIPTION[]    findAll()
 * @method INSCRIPTION[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class INSCRIPTIONRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, INSCRIPTION::class);
    }

    // /**
    //  * @return INSCRIPTION[] Returns an array of INSCRIPTION objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?INSCRIPTION
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
