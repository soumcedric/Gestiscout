<?php

namespace App\Repository;

use App\Entity\ResponsableDistrict;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResponsableDistrict|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponsableDistrict|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponsableDistrict[]    findAll()
 * @method ResponsableDistrict[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponsableDistrictRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponsableDistrict::class);
    }

    // /**
    //  * @return ResponsableDistrict[] Returns an array of ResponsableDistrict objects
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
    public function findOneBySomeField($value): ?ResponsableDistrict
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
