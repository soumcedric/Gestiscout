<?php

namespace App\Repository;

use App\Entity\Responsable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Responsable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Responsable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Responsable[]    findAll()
 * @method Responsable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponsableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Responsable::class);
    }

    // /**
    //  * @return Responsable[] Returns an array of Responsable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Responsable
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findOneByID($value): ?Responsable
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function finActiveResponsable()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.Statut = :val')
            ->setParameter('val', 1)
            ->orderBy('r.id', 'ASC')
          //  ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function GetResponsabeByGroupe($value)
    {
        $qdb = $this->createQueryBuilder('j')
            ->select('count(j.id)')
            ->innerJoin('App\Entity\Groupe','g',\Doctrine\ORM\Query\Expr\Join::WITH,'g.id=j.groupe')
            ->where('g.id = :id')
            ->andWhere('g.id = :id')
            ->setParameter(':id',$value);

        $result = $qdb->getQuery()->getSingleScalarResult();
        return $result;
    }


}
