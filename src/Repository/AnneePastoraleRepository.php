<?php

namespace App\Repository;

use App\Entity\AnneePastorale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @method AnneePastorale|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnneePastorale|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnneePastorale[]    findAll()
 * @method AnneePastorale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnneePastoraleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnneePastorale::class);
    }

    // /**
    //  * @return AnneePastorale[] Returns an array of AnneePastorale objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnneePastorale
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findActiveYear()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.bActif = 1')
           // ->setParameter('val', $value)
          //  ->orderBy('a.id', 'ASC')
          //  ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }


    public function findUniqueAnneePastorale($value)
    {
        $valConverter = (int)$value;
        return $this->createQueryBuilder('a')
                    ->andWhere('a.id = 1')
          //  ->setParameter('val',1)
            //  ->orderBy('a.id', 'ASC')
            //  ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
}
