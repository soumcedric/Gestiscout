<?php

namespace App\Repository;

use App\Entity\TresorerieActivite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TresorerieActivite|null find($id, $lockMode = null, $lockVersion = null)
 * @method TresorerieActivite|null findOneBy(array $criteria, array $orderBy = null)
 * @method TresorerieActivite[]    findAll()
 * @method TresorerieActivite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TresorerieActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TresorerieActivite::class);
    }

    // /**
    //  * @return TresorerieActivite[] Returns an array of TresorerieActivite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TresorerieActivite
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
