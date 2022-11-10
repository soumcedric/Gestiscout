<?php

namespace App\Repository;

use App\Entity\CaisseDistrict;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CaisseDistrict|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaisseDistrict|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaisseDistrict[]    findAll()
 * @method CaisseDistrict[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaisseDistrictRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CaisseDistrict::class);
    }

    // /**
    //  * @return CaisseDistrict[] Returns an array of CaisseDistrict objects
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
    public function findOneBySomeField($value): ?CaisseDistrict
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
