<?php

namespace App\Repository;

use App\Entity\MouvementTresoActivite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MouvementTresoActivite|null find($id, $lockMode = null, $lockVersion = null)
 * @method MouvementTresoActivite|null findOneBy(array $criteria, array $orderBy = null)
 * @method MouvementTresoActivite[]    findAll()
 * @method MouvementTresoActivite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MouvementTresoActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MouvementTresoActivite::class);
    }

    // /**
    //  * @return MouvementTresoActivite[] Returns an array of MouvementTresoActivite objects
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
    public function findOneBySomeField($value): ?MouvementTresoActivite
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
