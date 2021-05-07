<?php

namespace App\Repository;

use App\Entity\ExercerFonction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExercerFonction|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExercerFonction|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExercerFonction[]    findAll()
 * @method ExercerFonction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExercerFonctionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExercerFonction::class);
    }

    public function findFonctionChef($respoid, $activeYEar)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.Responsable = :val')
            ->setParameter('val', $respoid)
            ->andWhere('e.AnneePastorale = :year')
            ->setParameter('year', $activeYEar)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return ExercerFonction[] Returns an array of ExercerFonction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExercerFonction
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findById($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
           // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
}
