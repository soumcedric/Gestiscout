<?php

namespace App\Repository;

use App\Entity\RubriqueBudget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RubriqueBudget|null find($id, $lockMode = null, $lockVersion = null)
 * @method RubriqueBudget|null findOneBy(array $criteria, array $orderBy = null)
 * @method RubriqueBudget[]    findAll()
 * @method RubriqueBudget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RubriqueBudgetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RubriqueBudget::class);
    }

    // /**
    //  * @return RubriqueBudget[] Returns an array of RubriqueBudget objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RubriqueBudget
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
