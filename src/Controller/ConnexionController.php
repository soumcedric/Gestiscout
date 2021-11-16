<?php

namespace App\Controller;

//use http\Env\Request;
use App\Entity\Groupe;
use App\Entity\UserConnectedInfo;
use App\Repository\GroupeRepository;
use App\Repository\JEUNERepository;
use App\Repository\ResponsableRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use function Symfony\Component\Translation\t;
use App;


class ConnexionController extends AbstractController
{

    private $rapport;
    private $JeuneLayer;
    private $ResponsableLayer;
    private $EntityManager;
    
    private $AnneePastorale;
    public function __construct(RapportController $rapport, JEUNERepository $jeune, ResponsableRepository  $Responsable, EntityManagerInterface  $Emanager,App\Repository\AnneePastoraleRepository $an)
    {
        $this->rapport = $rapport;
        $this->JeuneLayer=$jeune;
        $this->ResponsableLayer=$Responsable;
        $this->EntityManager=$Emanager;
        $this->AnneePastorale=$an;


    }




    #[Route('/connexion', name: 'connexion')]
    public function index(): Response
    {
        return $this->render('connexion/index.html.twig', [
            'controller_name' => 'ConnexionController',
        ]);
    }


    #[Route('/Dashboard', name: 'Dashboard')]
    public function Dashboard(SessionInterface $session, GroupeRepository $GroupeData, UserRepository $UserData, ResponsableRepository  $respo): Response
    {
        $id = $session->get('id');
        $ActiveYEar = $this->AnneePastorale->findActiveYear();
        $UneAnneePastorale =$ActiveYEar[0];
        $CodeAnnee = $UneAnneePastorale->getCodeAnnee();
        //get Total des jeunes par groupe
        
        $qClass = new App\Classes\QueryClass($this->EntityManager);

        $Idgroupe = $session->get('groupeid');
        $nbrejeuneCotise = $qClass->NbreJeuneCotise((int)$Idgroupe->getId(),(int)$ActiveYEar);
        $nbreRespoCotise = $qClass->NbreResponsableCotise((int)$Idgroupe->getId(),(int)$ActiveYEar);
       // $nbrejeuneCotise = $qClass->get((int)$ActiveYEar,(int)$Idgroupe->getId());
        //$JeuneGrope = $this->JeuneLayer->GetTotalJeuneByGroup((int)$Idgroupe->getId());
        $JeuneGrope = $qClass->GetNbreJeuneParGroupe(0,(int)$Idgroupe->getId());

        //$RespoGroupe = $this->ResponsableLayer->GetResponsabeByGroupe((int)$Idgroupe->getId());
        $RespoGroupe = $qClass->GetNbreResponsableByGroup(0,(int)$Idgroupe->getId());

        $TotalJeuneMasculin = $qClass->GetNbreJeuneByGenreByGroupe($Idgroupe->getId(),'1');
       
        $TotalJeuneFeminin = $qClass->GetNbreJeuneByGenreByGroupe($Idgroupe->getId(),'2');





        $TotalJeuneMasculin = $qClass->GetNbreJeuneByGenreByGroupe('1',$Idgroupe->getId());
        $TotalJeuneFeminin = $qClass->GetNbreJeuneByGenreByGroupe('2',$Idgroupe->getId());





/*

        $TotalLouveteau = $this->JeuneLayer->GetJeuneParUnite((int)$Idgroupe->getId(),1);
        $TotalEclaireur = $this->JeuneLayer->GetJeuneParUnite((int)$Idgroupe->getId(),2);
        $TotalCheminot = $this->JeuneLayer->GetJeuneParUnite((int)$Idgroupe->getId(),3);
        $TotalRoutier = $this->JeuneLayer->GetJeuneParUnite((int)$Idgroupe->getId(),4);

*/

        $TotalLouveteau = $qClass->GetNbreJeuneByGroupeByBrancheByAnnee($Idgroupe->getId(),1);
        $TotalEclaireur = $qClass->GetNbreJeuneByGroupeByBrancheByAnnee($Idgroupe->getId(),2);
        $TotalCheminot = $qClass->GetNbreJeuneByGroupeByBrancheByAnnee($Idgroupe->getId(),3);
        $TotalRoutier = $qClass->GetNbreJeuneByGroupeByBrancheByAnnee($Idgroupe->getId(),4);





        //  dump($TotalLouveteau);
        //  dump($TotalEclaireur);
        //  dump($TotalCheminot);
        //  dump($TotalRoutier);


        //get info groupe
        $groupe = $GroupeData->findGroupeById($Idgroupe);
        $user = $UserData->findOneById($id);
        $Responsable = $user->getResponsable()->getId();
        $infoResponsable = $respo->findOneByID($Responsable);


        $ConnectedUser = new UserConnectedInfo();
        $ConnectedUser->Groupe = $groupe[0]->getNom();
        $ConnectedUser->Nom = $infoResponsable->getNom();
        $ConnectedUser->Prenoms = $infoResponsable->getPrenoms();


        $TotalJeuneDistrict = $qClass->GetNbreJeune((int)$ActiveYEar[0]->getId());
        $TotalChefDistrict = $qClass->GetNbreChefDistrict((int)$ActiveYEar[0]->getId());
        $TotalJeuneByGroupeDistrict = $qClass->GetNbreJeuneByGroupeDistrict((int)$ActiveYEar[0]->getId());
        $TotalJeuneParBrancheDistrict = $qClass->GetNbreJeuneParBranche((int)$ActiveYEar[0]->getId());
        

        //nombre de chef cotisé par groupe
        $TotalChefCotiseGroupe = $qClass->GetNbreResponsableCotiseParGroupe((int)$ActiveYEar[0]->getId(),$groupe[0]->getId());

        //nombre de jeune cotisé par groupe
        $TotalJeuneCotiseGroupe = $qClass->GetNbreJeuneCotiseParGroupe((int)$ActiveYEar[0]->getId(),$groupe[0]->getId());

        $nbreCotiseLouveteau = $qClass->GetNbreJeuneCotiseByCriteria($groupe[0]->getId(),1);
        $nbreCotiseEclaireur = $qClass->GetNbreJeuneCotiseByCriteria($groupe[0]->getId(),2);
        $nbreCotiseCheminot = $qClass->GetNbreJeuneCotiseByCriteria($groupe[0]->getId(),3);
        $nbreCotiseRoutier = $qClass->GetNbreJeuneCotiseByCriteria($groupe[0]->getId(),4);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('connexion/Dashboard.html.twig', [
            'controller_name' => 'ConnexionController',
            'groupe_name'=> $ConnectedUser->Groupe,
            'user_name'=> $ConnectedUser->Nom,
            'user_prenoms'=> $ConnectedUser->Prenoms,
            'TotalJeuneGroupe' => $JeuneGrope,
            'TotalResponsable' => $RespoGroupe,
            'TotalJeuneGarcon'=>$TotalJeuneMasculin,
            'TotalJeuneFille'=>$TotalJeuneFeminin,
            'TotalLouveteau'=>$TotalLouveteau,
            'TotalEclaireur'=>$TotalEclaireur,
            'TotalCheminot'=>$TotalCheminot,
            'TotalRoutier'=>$TotalRoutier,
            'NbreDeJeuneCotise'=>$nbrejeuneCotise,
            'Annee'=>$CodeAnnee,
            'NbreRespoCotise'=>$nbreRespoCotise,
            'NbreTotalJeuneDistrict' => $TotalJeuneDistrict,
            'TotalChefDistrict' => $TotalChefDistrict,
            'TotalJeuneByGroupe'=> $TotalJeuneByGroupeDistrict,
            'TotalChefCotiseGroupe'=>$TotalChefCotiseGroupe,
            'TotalJeuneCotiseGroupe'=>$TotalJeuneCotiseGroupe,
            'nbreCotiseLouveteau'=>$nbreCotiseLouveteau,
            'nbreCotiseEclaireur'=>$nbreCotiseEclaireur,
            'nbreCotiseCheminot'=>$nbreCotiseCheminot,
        'nbreCotiseRoutier'=>$nbreCotiseRoutier
        ]);
    }

    #[Route('/Login', name: 'Login')]
    public  function  LogIn()
    {
        return $this->render('connexion/index.html.twig');
    }

    #[Route('/DistrictDash', name: 'DistrictDash')]
    public  function DashboardDistrict()
    {
        $qClass = new App\Classes\QueryClass($this->EntityManager);
        //nombre de jeune par groupe
        //nombre de jeune saint sauveur misericordieux
        $nbreJeuneStSauveur = $qClass->GetNbreJeuneParGroupe(0,1);
        //nombre de jeune saint Marc
        $nbreJeuneLionKing = $qClass->GetNbreJeuneParGroupe(0,2);
        //nombre de jeune saint Marc
        $nbreJeuneLesPetroliers = $qClass->GetNbreJeuneParGroupe(0,3);
        //nombre de jeune SMA
        $nbreJeuneSma = $qClass->GetNbreJeuneParGroupe(0,4);
        //nombre de jeune NDA
        $nbreJeuneNda = $qClass->GetNbreJeuneParGroupe(0,5);

        //nombre de jeune et responsable cotisé par groupe MOHICANS
        $nbreTotalCotiseSSM=0;
        $nbreRespoCotiseSSM = $qClass->GetNbreResponsableCotiseParGroupe(0,1);
        $nbreJeuneCotiseSSM = $qClass->GetNbreJeuneCotiseParGroupe(0,1);
        $nbreTotalCotiseSSM = $nbreRespoCotiseSSM+$nbreJeuneCotiseSSM;

        //nombre de jeune et responsable cotisé par groupe LION KING
        $nbreTotalCotiseSM=0;
        $nbreRespoCotiseSM = $qClass->GetNbreResponsableCotiseParGroupe(0,2);
        $nbreJeuneCotiseSM = $qClass->GetNbreJeuneCotiseParGroupe(0,2);
        $nbreTotalCotiseSM = $nbreRespoCotiseSM+$nbreJeuneCotiseSM;

        //nombre de jeune et responsable cotisé par groupe PETROLIER
        $nbreTotalCotiseJMV=0;
        $nbreRespoCotiseJMV = $qClass->GetNbreResponsableCotiseParGroupe(0,3);
        $nbreJeuneCotiseJMV = $qClass->GetNbreJeuneCotiseParGroupe(0,3);
        $nbreTotalCotiseJMV = $nbreRespoCotiseJMV+$nbreJeuneCotiseJMV;


        //nombre de jeune et responsable cotisé par groupe SMA
        $nbreTotalCotiseSMA=0;
        $nbreRespoCotiseSMA = $qClass->GetNbreResponsableCotiseParGroupe(0,4);
        $nbreJeuneCotiseSMA = $qClass->GetNbreJeuneCotiseParGroupe(0,4);
        $nbreTotalCotiseSMA = $nbreRespoCotiseSMA+$nbreJeuneCotiseSMA;


        //nombre de jeune et responsable cotisé par groupe NDA
        $nbreTotalCotiseNDA=0;
        $nbreRespoCotiseNDA = $qClass->GetNbreResponsableCotiseParGroupe(0,5);
        $nbreJeuneCotiseNDA = $qClass->GetNbreJeuneCotiseParGroupe(0,5);
        $nbreTotalCotiseNDA = $nbreRespoCotiseNDA+$nbreJeuneCotiseNDA;


        //nombre de jeune cotisé par groupe et par branche



        return $this->render('connexion/DashboardDistrict.html.twig', [
            'controller_name' => 'ConnexionController',
            'nbreJeuneSsm' => $nbreJeuneStSauveur,
            'NbreJeuneLionKing' => $nbreJeuneLionKing,
            'nbreJeuneLesPetroliers' =>$nbreJeuneLesPetroliers,
            'nbreJeuneSma'=>$nbreJeuneSma,
            'nbreJeuneNda' => $nbreJeuneNda,
            'nbreTotalCotiseSSM'=>$nbreTotalCotiseSSM,
            'nbreTotalCotiseSM' => $nbreTotalCotiseSM,
            'nbreTotalCotiseJMV'=>$nbreTotalCotiseJMV,
            'nbreTotalCotiseSMA'=>$nbreTotalCotiseSMA,
            'nbreTotalCotiseNDA'=>$nbreTotalCotiseNDA


            ]);
    }







}
