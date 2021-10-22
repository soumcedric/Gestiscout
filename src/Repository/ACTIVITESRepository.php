<?php

namespace App\Repository;

use App\Entity\ACTIVITES;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method ACTIVITES|null find($id, $lockMode = null, $lockVersion = null)
 * @method ACTIVITES|null findOneBy(array $criteria, array $orderBy = null)
 * @method ACTIVITES[]    findAll()
 * @method ACTIVITES[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ACTIVITESRepository extends ServiceEntityRepository
{
    private $em;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, ACTIVITES::class);
        $this->em=$em;
    }

    // /**
    //  * @return ACTIVITES[] Returns an array of ACTIVITES objects
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
    public function findOneBySomeField($value): ?ACTIVITES
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function getAllActivite()
    {
       return $this->createQueryBuilder('a')
                    ->getQuery();
            
    }
}
