<?php

namespace App\Repository;

use App\Entity\Bilantresorerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bilantresorerie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bilantresorerie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bilantresorerie[]    findAll()
 * @method Bilantresorerie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilantresorerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bilantresorerie::class);
    }

    // /**
    //  * @return Bilantresorerie[] Returns an array of Bilantresorerie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bilantresorerie
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
