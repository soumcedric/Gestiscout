<?php

namespace App\Repository;

use App\Entity\MouvementEntite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MouvementEntite|null find($id, $lockMode = null, $lockVersion = null)
 * @method MouvementEntite|null findOneBy(array $criteria, array $orderBy = null)
 * @method MouvementEntite[]    findAll()
 * @method MouvementEntite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MouvementEntiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MouvementEntite::class);
    }

    // /**
    //  * @return MouvementEntite[] Returns an array of MouvementEntite objects
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
    public function findOneBySomeField($value): ?MouvementEntite
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
