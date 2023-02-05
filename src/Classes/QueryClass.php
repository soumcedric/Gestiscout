<?php


namespace App\Classes;


use App\Entity\AnneePastorale;
use App\Entity\JEUNE;
use App\Entity\Responsable;
use App\Repository\AnneePastoraleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

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
        // $sql = "SELECT count(j.id) FROM App\Entity\JEUNE j";
        // $sql = $sql. ", App\Entity\INSCRIPTION i ";
        // $sql= $sql ."where i.Jeunes = j.id ";
        // $sql = $sql. "and j.Groupe = :gr ";
        // $sql = $sql. "and i.Annee = :annee";
        // $sql = $sql. " and j.Statut = 1";
        // $query=$this->em->createQuery($sql);
        // $query->setParameter('gr',$groupe);
        // //$query->setParameter('annee',$year);
        // $query->setParameter('annee', $this->activeYear);
        // $res = $query->getSingleScalarResult();
        // return $res;


        $query = "select count(*) from jeune j left join inscription i
                  on j.id = i.jeunes_id
                  where i.annee_id = ".$this->activeYear->getId()."
                  and j.groupe_id = ".$groupe."";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchOne();


    }

    // public  function GetNbreResponsableCotiseParGroupe($year,$groupe) : int
    // {
    //    $sql = "SELECT COUNT(r.id) FROM ";
    //    $sql = $sql."App\Entity\Responsable r,";
    //    $sql = $sql."App\Entity\ExercerFonction ex ";
    //    $sql = $sql."WHERE r.id = ex.Responsable ";
    //    $sql = $sql."AND r.Statut = 1 ";
    //    $sql = $sql."AND r.groupe = :groupe ";
    //     $sql = $sql."AND ex.AnneePastorale = :year ";
    //    $sql = $sql." and r.id in (SELECT IDENTITY(co.Responsable) FROM App\Entity\Cotisation co) ";

    //    $query = $this->em->createQuery($sql);
    //    $query->setParameter('year',$this->activeYear);
    //    $query->setParameter('groupe', $groupe);
    //    $res = $query->getSingleScalarResult();
    //    return $res;
    // }


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

            if($branche=="0")
            {
  $sql="SELECT j.id, j.Nom,j.Prenoms,j.Dob,j.Occupation,g.Nom as nomgroupe,j.Telephone,b.Libelle FROM App\Entity\JEUNE j,App\Entity\Groupe g, App\Entity\INSCRIPTION i, App\Entity\Branche b ";
            $sql=$sql." WHERE j.Groupe = g.id";
            $sql = $sql." AND j.id = i.Jeunes ";
            $sql = $sql." AND j.branche = b.id ";
            $sql = $sql."And g.id = :groupe ";
            $sql = $sql."AND i.Annee = :year ";
             $sql = $sql."ORDER BY b.id ASC";
           // $sql = $sql." AND b.id = :branche";

                 $query = $this->em->createQuery($sql);
            $query->setParameter('groupe',$groupe);
           // $query->setParameter('branche', $branche);
            $query->setParameter('year', $this->activeYear);
            }
            else{
                  $sql="SELECT j.id, j.Nom,j.Prenoms,j.Dob,j.Occupation,g.Nom as nomgroupe,j.Telephone, b.Libelle FROM App\Entity\JEUNE j,App\Entity\Groupe g, App\Entity\INSCRIPTION i, App\Entity\Branche b ";
            $sql=$sql." WHERE j.Groupe = g.id";
            $sql = $sql." AND j.id = i.Jeunes ";
            $sql = $sql." AND j.branche = b.id ";
            $sql = $sql."And g.id = :groupe ";
            $sql = $sql."AND i.Annee = :year";
            $sql = $sql." AND b.id = :branche ";
               $sql = $sql."ORDER BY b.id ASC";
                 $query = $this->em->createQuery($sql);
            $query->setParameter('groupe',$groupe);
            $query->setParameter('branche', $branche);
            $query->setParameter('year', $this->activeYear);
            }


          
       
            $res = $query->getResult();
            return $res;
        }
        public  function GetListeResponsableByCriteria($groupe)
    {
        // $sql = "SELECT r.id,r.Nom,r.Prenoms,r.Dob,r.Occupation,r.Habitation,f.Libelle,r.Telephone,g.Nom as Groupe FROM App\Entity\Responsable r, App\Entity\ExercerFonction ex, App\Entity\Groupe g, App\Entity\FONCTION f ";
        // $sql =$sql."WHERE r.id = ex.Responsable ";
        // $sql =$sql."AND r.groupe = g.id ";
        // $sql = $sql." AND r.Statut = 1 ";
        // $sql =$sql."AND f.id = ex.Fonction ";
        // $sql =$sql."AND r.groupe = :groupe " ;
        // $sql =$sql."AND ex.AnneePastorale = :year" ;
        // $query = $this->em->createQuery($sql);
        // $query->setParameter('groupe',$groupe);
        // //$query->setParameter('branche', $branche);
        // $query->setParameter('year', $this->activeYear);
        $query = "select r.id, r.Nom, r.Prenoms,r.Dob, r.Occupation, r.Habitation, fm.libelle Formation, f.Libelle, r.Telephone, g.Nom as Groupe
                    from responsable r left OUTER JOIN exercer_fonction ex
                    on r.id = ex.responsable_id
                    LEFT outer join fonction f 
                    on ex.fonction_id = f.id
                    left outer join groupe g
                    on r.groupe_id = g.id
                    left outer join formation_responsable form
                    on r.id = form.responsable_id
                    left outer join formation fm
                    on form.formation_id = fm.id
                    where r.groupe_id = ".$groupe."
                    and ex.annee_pastorale_id=".$this->activeYear->getId()."; ";

                    $stmt = $this->em->getConnection()->prepare($query);
                    $stmt->execute();
        return $stmt->fetchAllAssociative();
    }
        public  function GetListeJeuneCotiseByCriteria($groupe,$branche)
        {
            if($branche=="0")
            {
                //tout les branches
   $sql = "SELECT c.id,c.Matricule,j.Nom,j.Prenoms,j.Telephone,g.Nom as Groupe FROM App\Entity\Cotisation c, App\Entity\JEUNE j, App\Entity\INSCRIPTION i, App\Entity\Groupe g";
            $sql=$sql." WHERE c.Jeune = j.id";
            $sql=$sql." AND j.id = i.Jeunes";
            $sql=$sql." AND j.Groupe = g.id";
            $sql=$sql." AND j.Groupe = :groupe";
            //$sql=$sql." AND j.branche = :branche";
            }
            else{
                   $sql = "SELECT c.id,c.Matricule,j.Nom,j.Prenoms,j.Telephone,g.Nom as Groupe FROM App\Entity\Cotisation c, App\Entity\JEUNE j, App\Entity\INSCRIPTION i, App\Entity\Groupe g";
            $sql=$sql." WHERE c.Jeune = j.id";
            $sql=$sql." AND j.id = i.Jeunes";
            $sql=$sql." AND j.Groupe = g.id";
            $sql=$sql." AND j.Groupe = :groupe";
            $sql=$sql." AND j.branche = :branche";
            }
         
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


    // public function GetAllActivites()
    // {
    //     $query = "select responsable.id, Nom,Prenoms,Occupation,Telephone,Habitation,Dob,fonction.id fonctionId, 
    //     fonction.libelle fonctionlibelle, formation.id formationId, formation.libelle formationlibelle from responsable,
    //      exercer_fonction , fonction, responsable_formation, formation
    //     where responsable.id = exercer_fonction.responsable_id
    //     and exercer_fonction.fonction_id = fonction.id
    //     and responsable.id = responsable_formation.responsable_id_id
    //     and responsable_formation.formation_id_id = formation.id
    //     and exercer_fonction.annee_pastorale_id = '".$this->activeYear->getId()."'
    //     and responsable.id ='".$id."';";
    //     $stmt = $this->em->getConnection()->prepare($query);
    //     $stmt->execute();
    //     return $stmt->fetchAllAssociative();

    // }











    public function GetAllProgrammesByActivite($activiteid){
        $query = "select id,libelle libelledetails, date datedetails, description, statut, deroulement,responsable_activite  from details where activite_id = '".$activiteid."'";
       
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }












    
    public function GetJeunesActifByGroupe($groupe)
    {
        // $conn = $this->em->getConnection();
        // $sql = "call SP_GET_JEUNES_ACTIF_BY_GROUPE('".$groupe."','".$this->activeYear->getId()."');";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute();
        // return $stmt->fetchAllAssociative();


        $sql="select jeunes.id, jeunes.nom, jeunes.prenoms, jeunes.dob, jeunes.occupation, jeunes.lieu_habitation, branche.libelle branche, groupe.nom groupe, jeunes.telephone
        from jeune jeunes, inscription inscriptions, branche branche, groupe groupe
        where jeunes.id = inscriptions.jeunes_id
        and jeunes.branche_id = branche.id
        and jeunes.groupe_id = groupe.id
        and inscriptions.annee_id = ".$this->activeYear->getId()."
        and jeunes.statut='1'
        and jeunes.groupe_id=".$groupe."
        order by jeunes.date_creation desc;";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAllAssociative();













    }

    public function GetResponsableActifByGroupe($groupe)
    {
        // $conn = $this->em->getConnection();
        // $sql = "call SP_GET_RESPONSABLE_ACTIF_BY_GROUPE('".$groupe."','".$this->activeYear->getId()."');";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute();
        // return $stmt->fetchAllAssociative();


        $sql = "SELECT responsables.id, responsables.nom, responsables.prenoms, responsables.dob, responsables.occupation, responsables.email,
        responsables.habitation, fonction.libelle fonction, responsables.telephone,formation.id formation_id, formation.libelle formation
        FROM responsable responsables, exercer_fonction exercer, groupe groupes, genre, fonction,formation, responsable_formation
        WHERE responsables.id = exercer.responsable_id
        and responsables.groupe_id = groupes.id
        and responsables.genre_id = genre.id
        and exercer.fonction_id = fonction.id
        and responsables.id = responsable_formation.responsable_id_id
        and formation.id = responsable_formation.formation_id_id
        and responsables.statut = '1'
        and responsables.groupe_id = ".$groupe."
        and exercer.annee_pastorale_id = ".$this->activeYear->getId().";";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAllAssociative();


    }



    public function GetResponsablesNonCotiseParGroupe($groupe)
    {
        // $conn = $this->em->getConnection();
        // $sql = "call SP_GET_RESPONSABLES_NON_COTISE_PAR_GROUPE('".$this->activeYear->getId()."','".$groupe."');";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute();
        // return $stmt->fetchAllAssociative();



        $sql = "select r.Id, r.Nom, r.Prenoms, r.Telephone
        from responsable r, exercer_fonction ex
        where r.id = ex.responsable_id
        and ex.annee_pastorale_id=".$this->activeYear->getId()."
        and r.groupe_id = ".$groupe."
        and r.id not in(select c.responsable_id from cotisation c where c.annee_pastorale_id=".$this->activeYear->getId()." and c.responsable_id is not null)";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }

    
  
    public function GetNbreJeuneByGroupeByBrancheByAnnee($groupe,$branche)
    {
        // $conn = $this->em->getConnection();
        // $sql = "call SP_GET_NBRE_JEUNE_BY_GROUPE_BRANCHE('".$groupe."','".$this->activeYear->getId()."','".$branche."');";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute();
        // return $stmt->fetchOne();

        $sql = "SELECT count(jeunes_id)
        FROM jeune jeunes, inscription inscriptions
        where jeunes.id = inscriptions.jeunes_id
        and inscriptions.annee_id=".$this->activeYear->getId()."
        and jeunes.statut = '1'
        and jeunes.groupe_id=".$groupe."
        and jeunes.branche_id= ".$branche.";";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchOne();




    }



    public function GetListeJeuneNonCotise($groupe)
    {
        // $conn = $this->em->getConnection();
        // $sql = "call SP_GET_JEUNES_NON_COTISE_PAR_GROUPE('".$groupe."','".$this->activeYear->getId()."');";

        // $stmt = $conn->prepare($sql);
        // $stmt->execute();
        // return $stmt->fetchAllAssociative();


        $sql = "select  jeune.id, jeune.nom, jeune.prenoms, jeune.telephone  from jeune left join inscription
        on jeune.id = inscription.jeunes_id
        LEFT outer join cotisation
        on cotisation.jeune_id = inscription.jeunes_id
        where jeune.groupe_id = ".$groupe."
        and inscription.annee_id = ".$this->activeYear->getId()."
        and cotisation.id is null";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAllAssociative();






    }
    //TOTAL JEUNE BY GENRE BY GROUPE
    public function GetNbreJeuneByGenreByGroupe($groupe,$genre)
    {
        // $conn = $this->em->getConnection();
        // $sql = "call SP_GET_NBRE_JEUNE_BY_GROUPE_BY_GENRE_BY_ANNEE('".$genre."','".$this->activeYear->getId()."','".$groupe."');";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute();
        // return $stmt->fetchOne();

        $sql = "SELECT count(j.id) FROM jeune j, inscription i  where j.id = i.jeunes_id  and j.statut='1' and j.groupe_id=".$groupe." and i.annee_id=".$this->activeYear->getId()." and j.genre_id=".$genre."";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchOne();

    }

    public function GetListeJeuneCotiseParGroupe($groupe)
    {
        // $conn = $this->em->getConnection();
        // $sql = "call SP_GET_JEUNES_COTISES('".$groupe."','".$this->activeYear->getId()."');";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute();
        // return $stmt->fetchAllAssociative();


        $sql = "select j.id, j.nom, j.prenoms, c.matricule, j.telephone 
        from cotisation c, jeune j
        where c.jeune_id = j.id
        and c.annee_pastorale_id=".$this->activeYear->getId()."
        and j.groupe_id = ".$groupe."";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAllAssociative();


    }

    public function GetListResponsablesCotisesParGroupe($groupe)
    {
        // $conn = $this->em->getConnection();
        // $sql = "call SP_GET_RESPONSABLES_COTISES('".$this->activeYear->getId()."','".$groupe."');";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute();
        // return $stmt->fetchAllAssociative();

        $sql = "select cotisation.Matricule,r.Id, r.Nom, r.Prenoms, r.Telephone
        from responsable r, exercer_fonction ex, cotisation
        where r.id = ex.responsable_id
        and ex.responsable_id = cotisation.responsable_id
        and ex.annee_pastorale_id=".$this->activeYear->getId()."
        and r.groupe_id = ".$groupe."";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAllAssociative();




    }

    public function GetNbreResponsableCotiseParGroupe($groupe)
    {
        // $conn = $this->em->getConnection();
        // $sql = "call SP_GET_NBRE_RESPO_COTISE_PAR_GROUPE('".$this->activeYear->getId()."','".$groupe."');";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute();
        // return $stmt->fetchOne();

        $query = "select count(r.id)
        from responsable r, exercer_fonction ex, cotisation
        where r.id = ex.responsable_id
        and ex.responsable_id = cotisation.responsable_id
        and ex.annee_pastorale_id=".$this->activeYear->getId()."
        and r.groupe_id = ".$groupe."";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchOne();
        









    }


    public function GetNbreJeunesCotiseParGroupe($groupe)
    {
        // $conn = $this->em->getConnection();
        // $sql = "call SP_GET_NBRE_JEUNES_COTISE_PAR_GROUPE('".$this->activeYear->getId()."','".$groupe."');";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute();
        // return $stmt->fetchOne();

        $query = "select count(jeune.id) from cotisation , jeune  where cotisation.jeune_id = jeune.id and cotisation.annee_pastorale_id=".$this->activeYear->getId()." and jeune.groupe_id = ".$groupe.";";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchOne();
        

    }


    public function GetResponsableUnique($id)
    {
        $query = "select responsable.id, Nom,Prenoms,Occupation,Telephone,Habitation,Dob,fonction.id fonctionId, responsable.email,
        fonction.libelle fonctionlibelle, formation.id formationId, formation.libelle formationlibelle from responsable,
         exercer_fonction , fonction, responsable_formation, formation
        where responsable.id = exercer_fonction.responsable_id
        and exercer_fonction.fonction_id = fonction.id
        and responsable.id = responsable_formation.responsable_id_id
        and responsable_formation.formation_id_id = formation.id
        and exercer_fonction.annee_pastorale_id = '".$this->activeYear->getId()."'
        and responsable.id ='".$id."';";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
       
    }

    public function GetExercerfonction($respo)
    {
        $query="SELECT * from exercer_fonction where responsable_id = '".$respo."' and annee_pastorale_id = '".$this->activeYear->getId()."'";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchOne();
       
    }


    public function GetChefByFormation($groupe, $formation)
    {

        if($groupe=="TOUT" && $formation<>"TOUT")
        {
            $query="select r.id, r.nom, r.prenoms,r.dob, f.libelle,g.paroisse from responsable r, responsable_formation rf, formation f, groupe g
            where r.id = rf.responsable_id_id
            and rf.formation_id_id = f.id
            and r.groupe_id = g.id
            and rf.formation_id_id = '".$formation."'";
        }
        else if($formation=="TOUT" && $groupe<>"TOUT") 
        {
            $query="select r.id, r.nom, r.prenoms,r.dob, f.libelle,g.paroisse from responsable r, responsable_formation rf, formation f, groupe g
            where r.id = rf.responsable_id_id
            and rf.formation_id_id = f.id
            and r.groupe_id = g.id
            and r.groupe_id='".$groupe."'";
        }
        else if($groupe=="TOUT" && $formation=="TOUT")
        {
            $query="select r.id, r.nom, r.prenoms,r.dob, f.libelle,g.paroisse from responsable r, responsable_formation rf, formation f, groupe g
            where r.id = rf.responsable_id_id
            and rf.formation_id_id = f.id
            and r.groupe_id = g.id";
        }
        else
        {
            $query="select r.id, r.nom, r.prenoms,r.dob, f.libelle,g.paroisse from responsable r, responsable_formation rf, formation f, groupe g
            where r.id = rf.responsable_id_id
            and rf.formation_id_id = f.id
            and r.groupe_id = g.id
            and r.groupe_id='".$groupe."'
            and rf.formation_id_id = '".$formation."'";
        }




        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
       
    }




 public function GetNextStageFormation($stage)
    {


        $querystage = "select ordre from formation where id='".$stage."'";
        $stmt = $this->em->getConnection()->prepare($querystage);
        $stmt->execute();
        $order = $stmt->fetchOne();
        $stagetogo = $order-1;
        //maintenant qu'on a l'ordre on va le convertir en int et faire - 1 pour avoir le stage précédent

        $querypreivision = "select r.id, r.nom,r.prenoms, r.telephone, g.nom groupe, f.libelle from responsable r,                       responsable_formation rf, formation f, groupe g
                            where r.id = rf.responsable_id_id
                            and rf.formation_id_id = f.id
                            and r.groupe_id = g.id
                            and f.ordre = '".$stagetogo."'";
        $stmt = $this->em->getConnection()->prepare($querypreivision);
        $stmt->execute();
        return $stmt->fetchAllAssociative();


       
    }



    /*REQUETES ACTIVITES*/

    public function ListActiviteByGroupe($groupe,$bsoumis)
    {
        if($bsoumis==false){
            $query = "select ac.id, ac.nom nomactivite,gr.nom nomgroupe,ac.date_debut,ac.date_fin,ac.prix,ac.nbre_participant,ac.statut, b_soumis,
             commentaire,
             case 
             when branche_id is null then 'GROUPE' 
           else (select libelle from branche where id = branche_id)
          end
          cible
             from activites ac, annee_pastorale an, groupe gr
        where ac.groupe_id = gr.id
        and ac.anneepastorale_id = an.id
        and gr.id = '".$groupe."'
        and an.id = '".$this->activeYear->getId()."'";
        }
        else{
            $query = "select ac.id, ac.nom nomactivite,gr.nom nomgroupe,ac.date_debut,ac.date_fin,ac.prix,ac.nbre_participant,ac.statut, b_soumis, commentaire,
            case 
            when branche_id is null then 'GROUPE' 
          else (select libelle from branche where id = branche_id)
         end
         cible
            from activites ac, annee_pastorale an, groupe gr
        where ac.groupe_id = gr.id
        and ac.anneepastorale_id = an.id
        and gr.id = '".$groupe."'
        and ac.b_soumis != 0
        and an.id = '".$this->activeYear->getId()."'";
        }
        // $query = "select ac.id, ac.nom nomactivite,gr.nom nomgroupe,ac.date_debut,ac.date_fin,ac.prix,ac.nbre_participant,ac.statut, b_soumis, commentaire
        // from activites ac, annee_pastorale an, groupe gr
        // where ac.groupe_id = gr.id
        // and ac.anneepastorale_id = an.id
        // and gr.id = '".$groupe."'
        // and an.id = '".$this->activeYear->getId()."'";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }

    /*REQUETES ACTIVITES*/



    /* GET INFO GROUPE*/
    public function GetInfoGroupe($groupe)
    {
        $query = "SELECT * FROM GROUPE WHERE id='".$groupe."'";
      
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }

    /** */


    /*GET DISTRICT LINKIED TO A GROUP*/
    public function GetGroupeUnique($groupeid){
        $query = "select * from groupe where id = '".$groupeid."'";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }

    /**/



      /*GET FORMATION SESSIONS*/
      public function GetSessions(){
        $query = "select session_formation.id id, Lieu,date_debut DateDebut,date_fin DateFin,directeur_stage DirecteurStage, formation.libelle Stage
        from session_formation, formation
        where session_formation.stage_formation_id = formation.id";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }

    /**/


    
      /*GET POTENTIAL PARTICIPANTS*/
      public function GetListParticipantformation($formationid){
        $query = "SELECT responsable.id id, responsable.nom nom , responsable.prenoms prenoms , fonction.libelle fonction, groupe.nom groupe FROM RESPONSABLE, responsable_formation, groupe, exercer_fonction, fonction
        where responsable.groupe_id = groupe.id
        and responsable.id = responsable_formation.responsable_id_id
        and responsable.id = exercer_fonction.responsable_id
        and exercer_fonction.fonction_id = fonction.id
        and responsable_formation.formation_id_id = '".$formationid."'
        and responsable.id not in (select responsable_id_id from session_formation_responsable)
        and exercer_fonction.annee_pastorale_id = '".$this->activeYear->getId()."' ";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }

    /**/



     /*GET POTENTIAL PARTICIPANTS*/
     public function GetResponsableBy_nextSession($sessionid){
        $query = "select session_formation_responsable.id Id,
         responsable.nom Nom , responsable.prenoms Prenoms, groupe.nom Groupe
        from session_formation_responsable, responsable, groupe, exercer_fonction, fonction
        where session_formation_responsable.responsable_id_id = responsable.id
        and responsable.groupe_id = groupe.id
        and responsable.id = exercer_fonction.responsable_id
        and exercer_fonction.fonction_id = fonction.id
        and session_formation_responsable.bconfirm_pariticpation = 0
        and session_id_id = '".$sessionid."'
        and annee_pastorale_id = '".$this->activeYear->getId()."' ";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }

    /**/


     /*GET  PARTICIPANTS WITH CONFIRMATION*/
     public function GetResponsableWithConfirmationToStage($sessionid){
        $query = "select 
         responsable.nom Nom , responsable.prenoms Prenoms, responsable.dob,responsable.occupation, fonction.libelle,responsable.telephone, groupe.nom Groupe
        from session_formation_responsable, responsable, groupe, exercer_fonction, fonction
        where session_formation_responsable.responsable_id_id = responsable.id
        and responsable.groupe_id = groupe.id
        and responsable.id = exercer_fonction.responsable_id
        and exercer_fonction.fonction_id = fonction.id
        and session_formation_responsable.bconfirm_pariticpation = 1
        and session_id_id = ".$sessionid."";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }

    /**/


    /*GET DOCUMENTS BY ACTIVITE*/
    public function GetDocumentByActivite($activiteid){
        $query = "select ac.id, dc.id docid, tp.libelle, dc.directory_path, dc.nom
        from activites ac, documents dc, type_document tp
        where ac.id = dc.activite_id
        and dc.type_document_id = tp.id
        and ac.id = ".$activiteid."";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }

    /**/


    /*GET MOUVEMENT*/
    public function GetMouvementDistrict($id)
    {
        $query = "select mouvement_district.*, type_mouvement.id, type_mouvement.libelle type
        from mouvement_district, type_mouvement
        where mouvement_district.typemouvement_id = type_mouvement.id
        and  district_id = " . $id . "";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }
        /*GET RESPONSABLE ROLE*/
        public function GetRespoRole($respoId){
            $query = "select f.role
            from responsable r, exercer_fonction exf, fonction f
            where r.id = exf.responsable_id
            and exf.fonction_id = f.Id
            and exf.annee_pastorale_id ='".$this->activeYear->getId()."' 
            and r.id = '".$respoId."' ";
            $stmt = $this->em->getConnection()->prepare($query);
            $stmt->execute();
            return $stmt->fetchOne();
        }

    /*GET MOUVEMENT*/
    public function GetPeriodes()
    {
        $query = "select p.id, p.code, p.datedebut, p.datefin, p.etat, ap.code_annee codeannee
        from periode p , annee_pastorale ap
        where p.anneepastorale_id = ap.id" ;
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }
        /**/

    public function GetRubriques()
    {
        $query = "select *
        from rubrique" ;
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }

    public function GetSousRubriques()
    {
        $query = "select r.id, r.code, r.libelle, rs.libelle rubrique
        from rubrique r, sous_rubrique rs" ;
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }

    public function GetEvenements($identite)
    {
        $query = "select * from evenement
        where  id_entite=".$identite." " ;
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }

    public function GetSousRubrique($rubriqueid)
    {
        $query = "select * from sous_rubrique
        where  rubrique_id=".$rubriqueid." " ;
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }

    public function GetMouvementsByEvent(int $eventId)
    {
        $conn = $this->em->getConnection();
        $sql = "call SP_GET_MOUVEMENTS_BY_EVENT('".$eventId."');";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
        /*Groupe By District*/
        public function GetGroupeByDistrict($districtId){
            $query = "select id, nom, nick_name,commissariat_district_id from groupe where commissariat_district_id = ".$districtId."";
            $stmt = $this->em->getConnection()->prepare($query);
            $stmt->execute();
            return $stmt->fetchAllAssociative();
        }
    
    }
        /**/


    public function GetMouvementByEntite(int $entiteid)
    {
        $conn = $this->em->getConnection();
        $sql = "call GET_MOUVEMENT_ENTITE('".$entiteid."');";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
    }
        public function GetAllMembreDistrict()
        {
        $query = "select d.id, d.Nom, d.Prenoms, d.dob Dob , f.libelle fonction, d.telephone Telephone, d.id 'Action', 1 as 'district'
            from district d, exercer_fonction ef, exercer_fonction_district efd, fonction f
            where d.id = efd.district_id
            and efd.exercer_fonction_id = ef.id
            and ef.fonction_id = f.id
            UNION
            SELECT r.id, r.nom Nom, r.prenoms Prenoms, r.dob Dob, f.libelle fonction, r.telephone, r.id 'Action', 0 as 'district'
            FROM responsable r, exercer_fonction ef, fonction f
            where r.id = ef.responsable_id 
            and ef.fonction_id = f.id";
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAllAssociative();
        }

        public function GetFunctionDistrict($id)
        {
            $query = "select  f.role 
                    from district d, exercer_fonction ef, exercer_fonction_district efd, fonction f
                    where d.id = efd.district_id
                    and efd.exercer_fonction_id = ef.id
                    and ef.fonction_id = f.id
                    and d.id = ".$id." ";
            $stmt = $this->em->getConnection()->prepare($query);
            $stmt->execute();
            return $stmt->fetchOne();
        }

    public function GetSoldeEntite($entite,$entiteid)
    {
        $query = "select sum(montant) from mouvement_entite where entite_id = '".$entiteid."' and entite='".$entite."'" ;
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchOne();
    }

    public function GetSoldeMvtEntiteMensule($entite,$entiteid)
    {
        $firstDate = date('Y-m-01');
        $lastDate = date('Y-m-t');
        $query = "select sum(montant) from mouvement_entite where entite_id = ".$entiteid." and entite=".$entite."
        and datemvt>='".$firstDate."' and datemvt <= '".$lastDate."'" ;
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchOne();
    }
    /**/


    











        // public function GetStatDistrictDash()
        // {
        //     $conn = $this->em->getConnection();
        //     $sql = "call SP_GET_INFO_STATISTIQUE_ADMIN('".$groupe."','".$this->activeYear->getId()."');";
        //     $stmt = $conn->prepare($sql);
        //     $stmt->execute();
        //     return $stmt->fetchAllAssociative();

        // }


        public function GetListMembreDistrict($districtId)
        {
            $query = "select d.id id, d.nom Nom, d.prenoms Prenoms, f.libelle Fonction, d.telephone Telephone
            from district d, commissariat_district cd, exercer_fonction_district efd, exercer_fonction ef, fonction f
            where d.id = efd.district_id
            and efd.exercer_fonction_id = ef.id
            and ef.fonction_id = f.id
            and d.commissariat_district_id = cd.id
            and d.commissariat_district_id = '".$districtId."' ";
            $stmt = $this->em->getConnection()->prepare($query);
            $stmt->execute();
            return $stmt->fetchAllAssociative();
        }
    
    















}