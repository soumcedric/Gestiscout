<?php

namespace App\Repository;

use App\Entity\CaisseGroupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CaisseGroupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaisseGroupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaisseGroupe[]    findAll()
 * @method CaisseGroupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaisseGroupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CaisseGroupe::class);
    }

    // /**
    //  * @return CaisseGroupe[] Returns an array of CaisseGroupe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CaisseGroupe
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
