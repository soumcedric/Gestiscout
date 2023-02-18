<?php

namespace App\Repository;

use App\Entity\BilanTresoEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BilanTresoEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method BilanTresoEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method BilanTresoEvent[]    findAll()
 * @method BilanTresoEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilanTresoEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BilanTresoEvent::class);
    }

    // /**
    //  * @return BilanTresoEvent[] Returns an array of BilanTresoEvent objects
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
    public function findOneBySomeField($value): ?BilanTresoEvent
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
