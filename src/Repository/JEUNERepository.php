<?php

namespace App\Repository;

use App\Entity\JEUNE;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * @method JEUNE|null find($id, $lockMode = null, $lockVersion = null)
 * @method JEUNE|null findOneBy(array $criteria, array $orderBy = null)
 * @method JEUNE[]    findAll()
 * @method JEUNE[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JEUNERepository extends ServiceEntityRepository
{
    private $em;
    public function __construct(ManagerRegistry $registry,SessionInterface $session,EntityManagerInterface $entityManager)
    {
        $this->em=$entityManager;
        parent::__construct($registry, JEUNE::class);



    }

    // /**
    //  * @return JEUNE[] Returns an array of JEUNE objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JEUNE
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function GetJeuneActif($value)
    {

        return $this->createQueryBuilder('j')
            ->andWhere('j.Statut = 1')
            ->andWhere('j.Groupe = :param')
            ->setParameter('param',$value)
            ->orderBy('j.DateCreation', 'DESC')
           // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
    public function findOneById($value): ?JEUNE
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    public function GetTotalJeune():? Integer
    {

        $dql = "SELECT count(j) from App\Entity\JEUNE j";
        $query = $this->em->createQuery($dql);
        $totalJeune = $query->getScalarResult();


        return $totalJeune;
    }
//    public function GetTotalJeuneByGroup($value):?array
    public function GetTotalJeuneByGroup($value)
    {
        $qdb = $this->createQueryBuilder('j')
                    ->select('count(j.id)')
                   ->innerJoin('App\Entity\Groupe','g',\Doctrine\ORM\Query\Expr\Join::WITH,'g.id=j.Groupe')
                    ->where('g.id = :id')
                    ->setParameter(':id',$value);

        $result = $qdb->getQuery()->getSingleScalarResult();
        return $result;
     }



    public function GetTotalByGenre($value,$sexe)
    {
        $qdb = $this->createQueryBuilder('j')
            ->select('count(j.id)')
            ->innerJoin('App\Entity\Groupe','g',\Doctrine\ORM\Query\Expr\Join::WITH,'g.id=j.Groupe')
            ->innerJoin('App\Entity\Genre', 'ge', \Doctrine\ORM\Query\Expr\Join::WITH,'ge.id = j.Genre')
            ->where('g.id = :id')
            ->andWhere('ge.id = :sexe')
            ->andWhere('j.Statut = 1')
            ->setParameter(':id',$value)
            ->setParameter('sexe',$sexe)  ;

        $result = $qdb->getQuery()->getSingleScalarResult();
        return $result;
    }




    public function GetJeuneParUnite($value,$unite)
    {
        $qdb = $this->createQueryBuilder('j')
            ->select('count(j.id)')
            ->innerJoin('App\Entity\Groupe','g',\Doctrine\ORM\Query\Expr\Join::WITH,'g.id=j.Groupe')
            ->innerJoin('App\Entity\Branche', 'ge', \Doctrine\ORM\Query\Expr\Join::WITH,'ge.id = j.branche')
            ->where('g.id = :id')
            ->andWhere('ge.id = :branche')
            ->andWhere('j.Statut = 1')
            ->setParameter(':id',$value)
            ->setParameter('branche',$unite)  ;

        $result = $qdb->getQuery()->getSingleScalarResult();
        return $result;
    }



    public function GetJeuneNonCotise($value)
    {
        $qdb = $this->createQueryBuilder('j')
            //->select('count(j.id)')
            ->innerJoin('App\Entity\Groupe','g',\Doctrine\ORM\Query\Expr\Join::WITH,'g.id=j.Groupe')
            ->leftJoin('App\Entity\Cotisation', 'c', \Doctrine\ORM\Query\Expr\Join::WITH,'c.Jeune = j.id')
            ->where('g.id = :id')
            ->setParameter(':id',$value);

        $result = $qdb->getQuery()->getResult();
        return $result;
    }



    public function GetJeuneCotise($value)
    {
        $qdb = $this->createQueryBuilder('j')
            //->select('count(j.id)')
            ->innerJoin('App\Entity\Groupe','g',\Doctrine\ORM\Query\Expr\Join::WITH,'g.id=j.Groupe')
            ->innerJoin('App\Entity\Cotisation', 'c', \Doctrine\ORM\Query\Expr\Join::WITH,'c.Jeune = j.id')
            ->where('g.id = :id')
            ->setParameter(':id',$value);

        $result = $qdb->getQuery()->getResult();
        return $result;
    }

  

   

}
