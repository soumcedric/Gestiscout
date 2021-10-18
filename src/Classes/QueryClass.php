<?php


namespace App\Classes;


use App\Entity\AnneePastorale;
use App\Entity\JEUNE;
use App\Entity\Responsable;
use App\Repository\AnneePastoraleRepository;
use Doctrine\ORM\EntityManagerInterface;

class QueryClass
{
    private $em;
    private $annee;
    private $activeYear;


    function __construct(EntityManagerInterface $EM)
    {
        $this->em=$EM;
        $this->activeYear = $this->em->getRepository(AnneePastorale::Class)->findOneBy(["bActif"=>true]);

    }

    function ListeJeuneCotiseParGroupe($groupeid,$ActiveYear)
    {
        $sql = "SELECT j FROM ";
        $sql = $sql."App\Entity\JEUNE j";
        $sql=$sql.", App\Entity\INSCRIPTION i";
        $sql=$sql.", App\Entity\Groupe g";
        $sql = $sql.",App\Entity\AnneePastorale an ";
        $sql = $sql."where j.Groupe = g.id ";
        $sql = $sql."and j.id = i.Jeunes ";
        $sql = $sql."and i.Annee = an.id ";
        $sql = $sql."and g.id = :groupeid and an.id = :anneeId";
        $sql = $sql." and j.id in (SELECT IDENTITY(co.Jeune) FROM App\Entity\Cotisation co) ";
        $query=$this->em->createQuery($sql);
        $query->setParameter("groupeid", $groupeid);
        $query->setParameter("anneeId",$ActiveYear);
        $res=$query->getResult();
        foreach ($res as $jeune)
        {
            $sql1 = "SELECT c.Matricule from App\Entity\Cotisation c where c.Jeune = :id";
            $q = $this->em->createQuery($sql1);
            //$id = $jeune->set
            $q->setParameter('id',$jeune->getId());
            $resultat = $q->getSingleResult();
            $matricule=$resultat["Matricule"];
            $jeune->setMatricule($matricule);
        }
        return $res;
    }


    public function GetJeuneNonCotise($groupeid,$ActiveYear)
    {

        $sql = "SELECT j FROM ";
        $sql = $sql."App\Entity\JEUNE j";
        $sql=$sql.", App\Entity\INSCRIPTION i ";
        $sql = $sql."where ";
        $sql = $sql." j.id = i.Jeunes ";
        $sql = $sql." and j.Statut = 1 ";
        $sql = $sql." and j.Groupe = :groupeid ";
        $sql = $sql." and i.Annee = :anneeId ";
        $sql=$sql." and j.id not in (select IDENTITY(c.Jeune) from App\Entity\Cotisation c where c.Jeune is not null)";
        $query=$this->em->createQuery($sql);
        $query->setParameter("groupeid", $groupeid);
        $query->setParameter("anneeId",$ActiveYear);
        $res=$query->getResult();
        //var_dump($res);
        //echo $res;
        return $res;


    }

    function NbreJeuneCotise($groupeid,$ActiveYear)
    {
        $sql = "SELECT count(j) FROM ";
        $sql = $sql."App\Entity\JEUNE j";
        $sql=$sql.", App\Entity\INSCRIPTION i";
        $sql=$sql.", App\Entity\Groupe g";
        $sql = $sql.",App\Entity\AnneePastorale an ";
        $sql = $sql."where j.Groupe = g.id ";
        $sql = $sql."and j.id = i.Jeunes ";
        $sql = $sql."and i.Annee = an.id ";
        $sql = $sql."and g.id = :groupeid and an.id = :anneeId";
        $sql = $sql." and j.id in (SELECT IDENTITY(co.Jeune) FROM App\Entity\Cotisation co) ";
        $query=$this->em->createQuery($sql);
        $query->setParameter("groupeid", $groupeid);
        $query->setParameter("anneeId",$ActiveYear);
        $res=$query->getSingleScalarResult();

        return $res;
    }
    public function GetResponsableNonCotise($groupeid,$ActiveYear)
    {

        $sql = "SELECT r FROM ";
        $sql=$sql."App\Entity\Responsable r, ";
        $sql=$sql."App\Entity\ExercerFonction ef, ";
        $sql=$sql."App\Entity\Groupe g, ";
        $sql=$sql."App\Entity\AnneePastorale an ";
        $sql=$sql."where r.id = ef.Responsable ";
        $sql=$sql."and ef.AnneePastorale = an.id ";
        $sql=$sql."and r.groupe = g.id ";
        $sql=$sql."and g.id = :groupeid";
        $sql=$sql." and an.id = :anneeId";
        $sql=$sql." and r.Statut = 1";
        $sql=$sql." and r.id not in (select IDENTITY(c.Responsable) from App\Entity\Cotisation c where c.Responsable is not null)";


        $query=$this->em->createQuery($sql);
        $query->setParameter("groupeid", $groupeid);
        $query->setParameter("anneeId",$ActiveYear);
        $res=$query->getResult();
        return $res;


    }
    public function GetResponsableCotiseParGroupe($groupeid,$ActiveYear)
    {

        $sql = "SELECT r FROM ";
//        $sql=$sql."App\Entity\Responsable r LEFT JOIN ";
//        $sql=$sql." App\Entity\ExercerFonction ef ";
//        $sql=$sql." ON r.id = ef.Responsable ";
//        $sql=$sql." WHERE r.Status = 1 ";
//        $sql=$sql." and g.id = :groupeid ";
//        $sql=$sql." and an.id = :anneeId ";
//        $sql=$sql." and r.id in (select IDENTITY(c.Responsable) from App\Entity\Cotisation c)";
//        var_dump($sql);




        $sql=$sql."App\Entity\Responsable r, ";
        $sql=$sql."App\Entity\ExercerFonction ef, ";
        $sql=$sql."App\Entity\Groupe g, ";
        $sql=$sql."App\Entity\AnneePastorale an ";
        $sql=$sql."where r.id = ef.Responsable ";
        $sql=$sql."and ef.AnneePastorale = an.id ";
        $sql=$sql."and r.groupe = g.id ";
        $sql=$sql."and g.id = :groupeid";
        $sql=$sql." and an.id = :anneeId";
        $sql=$sql." and r.id in (select IDENTITY(c.Responsable) from App\Entity\Cotisation c)";


        $query=$this->em->createQuery($sql);
        $query->setParameter("groupeid", $groupeid);
        $query->setParameter("anneeId",$ActiveYear);
        $res=$query->getResult();
        foreach ($res as $respo)
        {
            $sql1 = "SELECT c.Matricule from App\Entity\Cotisation c where c.Responsable = :id";
            $q = $this->em->createQuery($sql1);
            //$id = $jeune->set
            $q->setParameter('id',$respo->getId());
            $resultat = $q->getSingleResult();
            $matricule=$resultat["Matricule"];
            $respo->setMatricule($matricule);
        }




        return $res;


    }
    public function NbreResponsableCotise($groupeid,$ActiveYear)
    {

        $sql = "SELECT count(r) FROM ";
        $sql=$sql."App\Entity\Responsable r, ";
        $sql=$sql."App\Entity\ExercerFonction ef, ";
        $sql=$sql."App\Entity\Groupe g, ";
        $sql=$sql."App\Entity\AnneePastorale an ";
        $sql=$sql."where r.id = ef.Responsable ";
        $sql=$sql."and ef.AnneePastorale = an.id ";
        $sql=$sql."and r.groupe = g.id ";
        $sql=$sql."and g.id = :groupeid";
        $sql=$sql." and an.id = :anneeId";
        $sql=$sql." and r.id in (select IDENTITY(c.Responsable) from App\Entity\Cotisation c)";


        $query=$this->em->createQuery($sql);
        $query->setParameter("groupeid", $groupeid);
        $query->setParameter("anneeId",$ActiveYear);
        $res=$query->getSingleScalarResult();



        return $res;


    }
    public  function GetListResponsableActif($groupeid,$ActiveYear)
    {
        $sql="SELECT r from App\Entity\Responsable r, ";
        $sql=$sql."App\Entity\ExercerFonction ex, ";
        $sql=$sql."App\Entity\Fonction f, ";
        $sql=$sql."App\Entity\AnneePastorale an, ";
        $sql=$sql."App\Entity\Groupe g ";
        $sql=$sql." where r.id = ex.Responsable ";
        $sql=$sql." and ex.Fonction = f.id ";
        $sql=$sql." and ex.AnneePastorale = an.id ";
        $sql=$sql." and r.groupe = g.id ";
        $sql=$sql." and g.id = :groupeid ";
        $sql=$sql." and an.id = :anneeid ";
        $sql=$sql." and r.Statut = 1 ";


        $query=$this->em->createQuery($sql);
        $query->setParameter("groupeid", $groupeid);
        $query->setParameter("anneeid",$ActiveYear);
        $res=$query->getResult();
        $ListeRespo = [];
        foreach ($res as $respo)
        {

            $sql1="SELECT f.Libelle FROM App\Entity\ExercerFonction ef, App\Entity\Fonction f ";
            $sql1=$sql1." where f.id = ef.Fonction and ef.Responsable = :id";
             $q=$this->em->createQuery($sql1);
            $q->setParameter("id", $respo->getId());
            $val=$q->getSingleResult();
            $respo->setFonctionLibelle($val["Libelle"]);

        }

        return $res;
    }

    public  function GetListResponsableDistrictActif($groupeid,$ActiveYear)
    {
        $sql="SELECT r from App\Entity\Responsable r, ";
        $sql=$sql."App\Entity\ExercerFonction ex, ";
        $sql=$sql."App\Entity\Fonction f, ";
        $sql=$sql."App\Entity\AnneePastorale an, ";
        $sql=$sql."App\Entity\Groupe g ";
        $sql=$sql." where r.id = ex.Responsable ";
        $sql=$sql." and ex.Fonction = f.id ";
        $sql=$sql." and ex.AnneePastorale = an.id ";
        $sql=$sql." and r.groupe = g.id ";
       // $sql=$sql." and g.id = :groupeid ";
        $sql=$sql." and an.id = :anneeid ";
        $sql=$sql." and r.Statut = 1 ";


        $query=$this->em->createQuery($sql);
      //  $query->setParameter("groupeid", $groupeid);
        $query->setParameter("anneeid",$ActiveYear);
        $res=$query->getResult();
        $ListeRespo = [];
        foreach ($res as $respo)
        {

            $sql1="SELECT f.Libelle FROM App\Entity\ExercerFonction ef, App\Entity\Fonction f ";
            $sql1=$sql1." where f.id = ef.Fonction and ef.Responsable = :id";
             $q=$this->em->createQuery($sql1);
            $q->setParameter("id", $respo->getId());
            $val=$q->getSingleResult();
            $respo->setFonctionLibelle($val["Libelle"]);

        }

        return $res;
    }








    public  function CheckUserExist($username): ?bool
    {
        $sql="SELECT u FROM App\Entity\User u where u.username = :username";
        $query = $this->em->createQuery($sql);
        $query->setParameter("username",$username);
        $val = $query->getResult();
        if(empty($val)) return false; else return true;
    }


    public function GetNbreJeune($activeyear): ?int
    {
        $sql = " SELECT COUNT(j) FROM App\Entity\JEUNE j, app\Entity\INSCRIPTION i, App\Entity\AnneePastorale an ";
        $sql = $sql."where j.id = i.Jeunes";
        $sql = $sql." and an.id = i.Annee";
        $sql = $sql." and an.id = :annee";
        $query=$this->em->createQuery($sql);
        $query->setParameter('annee',$activeyear);
        $res = $query->getSingleScalarResult();
        return $res;

    }

    public function GetNbreJeuneByGroupeDistrict($activeyear)
    {
        $sql = " SELECT g.Nom, count(j.id) as NbreJeune FROM App\Entity\JEUNE j, app\Entity\INSCRIPTION i, App\Entity\AnneePastorale an, App\Entity\Groupe g ";
        $sql = $sql."where j.id = i.Jeunes";
        $sql = $sql." and an.id = i.Annee";
        $sql = $sql." and j.Groupe = g.id";
        $sql = $sql." and an.id = :annee";
        $sql = $sql." Group By g.Nom ";
        $query=$this->em->createQuery($sql);
        $query->setParameter('annee',$activeyear);
        $res = $query->getResult();
        return $res;
    }

    public  function GetNbreChefDistrict($activiteyear): ?int
    {
        $sql = "SELECT count(ef) from App\Entity\ExercerFonction ef, App\Entity\Responsable r ";
        $sql=$sql."WHERE ef.Responsable = r.id";
        $sql=$sql." and ef.AnneePastorale = :yearid";

        $query = $this->em->createQuery($sql);
        $query->setParameter('yearid',$activiteyear);
        $result = $query->getSingleScalarResult();
        return $result;
    }


    public function GetNbreJeuneParBranche($activeyear)
    {
        $sql = " SELECT b.Libelle, count(j.id) as NbreJeune FROM App\Entity\JEUNE j, app\Entity\INSCRIPTION i, App\Entity\AnneePastorale an, App\Entity\Branche b ";
        $sql = $sql."where j.id = i.Jeunes";
        $sql = $sql." and an.id = i.Annee";
        $sql = $sql." and j.branche = b.id";
        $sql = $sql." and an.id = :annee";
        $sql = $sql." Group By b.Libelle ";
        $query=$this->em->createQuery($sql);
        $query->setParameter('annee',$activeyear);
        $res = $query->getResult();
        return $res;
    }
    public function GetNbreJeuneParGroupe($year, $groupe)
    {
        $sql = "SELECT count(j.id) FROM App\Entity\JEUNE j";
        $sql = $sql. ", App\Entity\INSCRIPTION i ";
        $sql= $sql ."where i.Jeunes = j.id ";
        $sql = $sql. "and j.Groupe = :gr ";
        $sql = $sql. "and i.Annee = :annee";
        $sql = $sql. " and j.Statut = 1";
        $query=$this->em->createQuery($sql);
        $query->setParameter('gr',$groupe);
        //$query->setParameter('annee',$year);
        $query->setParameter('annee', $this->activeYear);
        $res = $query->getSingleScalarResult();
        return $res;
    }

    public  function GetNbreResponsableCotiseParGroupe($year,$groupe) : int
    {
       $sql = "SELECT COUNT(r.id) FROM ";
       $sql = $sql."App\Entity\Responsable r,";
       $sql = $sql."App\Entity\ExercerFonction ex ";
       $sql = $sql."WHERE r.id = ex.Responsable ";
       $sql = $sql."AND r.Statut = 1 ";
       $sql = $sql."AND r.groupe = :groupe ";
        $sql = $sql."AND ex.AnneePastorale = :year ";
       $sql = $sql." and r.id in (SELECT IDENTITY(co.Responsable) FROM App\Entity\Cotisation co) ";

       $query = $this->em->createQuery($sql);
       $query->setParameter('year',$this->activeYear);
       $query->setParameter('groupe', $groupe);
       $res = $query->getSingleScalarResult();
       return $res;
    }


    public  function GetNbreJeuneCotiseParGroupe($year,$groupe) : int
    {
        $sql = "SELECT count(j.id) FROM App\Entity\JEUNE j, App\Entity\INSCRIPTION i, App\Entity\Cotisation c where j.id = i.Jeunes and j.id = c.Jeune and i.Annee = :year and j.Groupe = :gr and j.Statut='1' ";
        $query = $this->em->createQuery($sql);
        $query->setParameter('year',$this->activeYear);
        $query->setParameter('gr', $groupe);
        $res = $query->getSingleScalarResult();
        return $res;
    }

    /*REQUETE GROUPE*/
    public  function GetNbreResponsableByGroup($year,$groupe) : int
    {
        $sql = " select count(r.id) from App\Entity\Responsable r, App\Entity\ExercerFonction ex WHERE r.id = ex.Responsable   and ex.AnneePastorale = :year and r.Statut = 1 and r.groupe = :groupe ";
        $query = $this->em->createQuery($sql);
        $query->setParameter('year',$this->activeYear);
        $query->setParameter('groupe', $groupe);
        $res = $query->getSingleScalarResult();
        return $res;
    }
    /*REQUETE GROUPE*/

    /*----------------------- debut requete district -----------------------------*/
        public  function GetListeJeuneByCriteria($groupe,$branche)
        {
            $sql="SELECT j.id, j.Nom,j.Prenoms,j.Dob,j.Telephone,g.Nom as nomgroupe FROM App\Entity\JEUNE j,App\Entity\Groupe g, App\Entity\INSCRIPTION i, App\Entity\Branche b ";
            $sql=$sql." WHERE j.Groupe = g.id";
            $sql = $sql." AND j.id = i.Jeunes ";
            $sql = $sql." AND j.branche = b.id ";
            $sql = $sql."And g.id = :groupe ";
            $sql = $sql."AND i.Annee = :year";
            $sql = $sql." AND b.id = :branche";
            $query = $this->em->createQuery($sql);
            $query->setParameter('groupe',$groupe);
            $query->setParameter('branche', $branche);
            $query->setParameter('year', $this->activeYear);
            $res = $query->getResult();
            return $res;
        }
        public  function GetListeResponsableByCriteria($groupe)
    {
        $sql = "SELECT r.id,r.Nom,r.Prenoms,r.Telephone,f.Code,g.Nom as Groupe FROM App\Entity\Responsable r, App\Entity\ExercerFonction ex, App\Entity\Groupe g, App\Entity\FONCTION f ";
        $sql =$sql."WHERE r.id = ex.Responsable ";
        $sql =$sql."AND r.groupe = g.id ";
        $sql = $sql." AND r.Statut = 1 ";
        $sql =$sql."AND f.id = ex.Fonction ";
        $sql =$sql."AND r.groupe = :groupe " ;
        $sql =$sql."AND ex.AnneePastorale = :year" ;
        $query = $this->em->createQuery($sql);
        $query->setParameter('groupe',$groupe);
        //$query->setParameter('branche', $branche);
        $query->setParameter('year', $this->activeYear);
        $res = $query->getResult();
        return $res;
    }
        public  function GetListeJeuneCotiseByCriteria($groupe,$branche)
        {
            $sql = "SELECT c.id,c.Matricule,j.Nom,j.Prenoms,j.Telephone,g.Nom as Groupe FROM App\Entity\Cotisation c, App\Entity\JEUNE j, App\Entity\INSCRIPTION i, App\Entity\Groupe g";
            $sql=$sql." WHERE c.Jeune = j.id";
            $sql=$sql." AND j.id = i.Jeunes";
            $sql=$sql." AND j.Groupe = g.id";
            $sql=$sql." AND j.Groupe = :groupe";
            $sql=$sql." AND j.branche = :branche";
            $query = $this->em->createQuery($sql);
            $query->setParameter('groupe',$groupe);
            $query->setParameter('branche',$branche);
            $res = $query->getResult();
            return $res;
        }
        public  function GetListeRespoCotiseByCriteria($groupe)
    {
        $sql = "SELECT c.id,c.Matricule,r.Nom,r.Prenoms,r.Telephone,g.Nom as Groupe FROM App\Entity\Cotisation c, App\Entity\Responsable r, App\Entity\ExercerFonction ex, App\Entity\Groupe g";
        $sql=$sql." WHERE c.Responsable = r.id ";
        $sql=$sql." AND r.id = ex.Responsable";
        $sql=$sql." AND r.groupe = g.id";
        $sql=$sql." AND r.Statut = 1";
        $sql=$sql." AND r.groupe = :groupe";

        $query = $this->em->createQuery($sql);
        $query->setParameter('groupe',$groupe);
        $res = $query->getResult();
        return $res;
    }

    /*----------------------- fin requete district -----------------------------*/



    /*----------------------- ID JEUNE -----------------------------*/
    public function GetLastIdJeune(){
        $sql = "SELECT j.id from App\Entity\JEUNE j ";
        $sql = $sql." ORDER BY j.DateCreation DESC ";
        $sql = $sql."limit 1 ";
        echo $sql;
        $query = $this->em->createQuery($sql);
        $res = $query->getResult();
       // echo $res;
        return $res;

    }
    /*----------------------- ID JEUNE -----------------------------*/

    /*----------------------- ID RESPONSABLE -----------------------------*/
    /*----------------------- ID RESPONSABLE -----------------------------*/


    public  function GetNbreJeuneCotiseByCriteria($groupe,$branche)
    {
        $sql = "SELECT count(c.id) FROM App\Entity\Cotisation c, App\Entity\JEUNE j, App\Entity\INSCRIPTION i, App\Entity\Groupe g";
        $sql=$sql." WHERE c.Jeune = j.id";
        $sql=$sql." AND j.id = i.Jeunes";
        $sql=$sql." AND j.Groupe = g.id";
        $sql=$sql." AND j.branche = :branche";
        $sql=$sql." AND j.Groupe = :groupe";
        $query = $this->em->createQuery($sql);
        $query->setParameter('groupe',$groupe);
        $query->setParameter('branche', $branche);

        $res = $query->getSingleScalarResult();
        return $res;
    }

}