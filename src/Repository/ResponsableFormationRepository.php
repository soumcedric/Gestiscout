<?php

namespace App\Repository;

use App\Entity\ResponsableFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResponsableFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponsableFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponsableFormation[]    findAll()
 * @method ResponsableFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponsableFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponsableFormation::class);
    }

    // /**
    //  * @return ResponsableFormation[] Returns an array of ResponsableFormation objects
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
    public function findOneBySomeField($value): ?ResponsableFormation
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
