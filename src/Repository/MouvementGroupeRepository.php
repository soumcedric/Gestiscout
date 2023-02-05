<?php

namespace App\Repository;

use App\Entity\MouvementGroupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MouvementGroupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method MouvementGroupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method MouvementGroupe[]    findAll()
 * @method MouvementGroupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MouvementGroupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MouvementGroupe::class);
    }

    // /**
    //  * @return MouvementGroupe[] Returns an array of MouvementGroupe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MouvementGroupe
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
