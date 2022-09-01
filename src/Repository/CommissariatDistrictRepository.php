<?php

namespace App\Repository;

use App\Entity\CommissariatDistrict;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommissariatDistrict|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommissariatDistrict|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommissariatDistrict[]    findAll()
 * @method CommissariatDistrict[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommissariatDistrictRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommissariatDistrict::class);
    }

    // /**
    //  * @return CommissariatDistrict[] Returns an array of CommissariatDistrict objects
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
    public function findOneBySomeField($value): ?CommissariatDistrict
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
