<?php

namespace App\Repository;

use App\Entity\SensRubrique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SensRubrique|null find($id, $lockMode = null, $lockVersion = null)
 * @method SensRubrique|null findOneBy(array $criteria, array $orderBy = null)
 * @method SensRubrique[]    findAll()
 * @method SensRubrique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SensRubriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SensRubrique::class);
    }

    // /**
    //  * @return SensRubrique[] Returns an array of SensRubrique objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SensRubrique
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
