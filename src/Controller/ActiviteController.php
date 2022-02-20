<?php

namespace App\Controller;

use App\Classes\QueryClass;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\entity\ACTIVITES;
use App\Entity\Branche;
use App\Entity\Groupe;
use App\Repository\ACTIVITESRepository;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\BrancheRepository;
use App\Repository\GroupeRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\DETAILS;
use App\Repository\DETAILSRepository;


class ActiviteController extends AbstractController
{
    private $em;
    private $activiteRepo;
   // private $rpBranche;
    public function __construct(EntityManagerInterface $em, BrancheRepository $rpbranche, ACTIVITESRepository $activite)
    {
        $this->em=$em;
        $this->activiteRepo=$activite;
        //$rpBranche = $rpbranche;
    }


    /**
     * @Route("/activite", name="activite")
     */
    public function index(): Response
    {
        return $this->render('activite/index.html.twig', [
            'controller_name' => 'ActiviteController',
        ]);
    }
    // /**
    //  * @Route("/AddActivite, name="AddActivite")
    //  */
    // public function AddActivite(Request $value)
    // {
    //     return $this->render('activite/index.html.twig', [
    //         'controller_name' => 'ActiviteController',
    //     ]);
    // }

     /**
     * @Route("/CreateActivite", name="CreateActivite")
     */
    public function CreateActivite(Request $value, ACTIVITESRepository $activite, BrancheRepository $rpBranche, GroupeRepository $rpGroupe){
       try{

     
        $data =  $value->request->get('value');
     
        $activity = new ACTIVITES();
        $activity -> setNom($data["Nom"])
                  ->setDescription($data["Description"])
                  ->setVille($data["Ville"])
                  ->setCommune($data["Commune"])
                  ->setLocalisation($data["Localisation"])
                  ->setPrix($data["Prix"])
                  ->setDateDebut(new \DateTime($data["DateDebut"]))
                  ->setDateFin(new \DateTime($data["DateFin"]))
                  ->setHeureDebut(new \DateTime($data["HeureDebut"]))
                  ->setHeureFin((new DateTime($data["HeureFin"])))
                  ->setStatut(0)
                  //->setAutorisation($data["Autorisation"])
                  ->setNbreParticipant($data["NbreParticipant"]);
                 // ->setGroupe($data["Groupe"])
                  //->setBranche($data["Branche"]);


        if(!empty($data["Branche"])){
            $selectedBranche = $rpBranche->findOneBy(["id"=>$data["Branche"]]);
            $activity->setBranche($selectedBranche);
        }

       
        if(!empty($data["Groupe"])){
            $selectedGroupe = $rpGroupe->findOneBy(["id"=>$data["Groupe"]]);
            $activity->setGroupe($selectedGroupe);
        }
       
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($activity);
        $manager->flush();

        return new JsonResponse(['ok'=> true, 'message'=>'opération effectuée avec succès']);
      //return  var_dump($activity);
      // return new Response('true',200);
      }catch(\Exception $e)
       {
        return new JsonResponse(['ok'=> false, 'message'=>$e->getMessage()]);
       }
        
    }



    /**
     * @Route("/Activites", name="Activites")
     */
    public function ListActivite():Response
    {
        return $this->render('activite/ListActivite.html.twig', [
            'controller_name' => 'ActiviteController',
        ]);
    }



     /**
     * @Route("/ListActivites", name="ListActivites")
     */
    public function ListActivites(ACTIVITESRepository $rpActivite,SerializerInterface $serializer)
    {
        $qClass = new QueryClass($this->em);
        $listactivites = $qClass->GetAllActivites();
        foreach($listactivites as $ac)
        {
           //dump($ac);
          // var_dump($ac);
        }
       $result = $serializer->serialize($listactivites,'json');
       return new JsonResponse(['ok'=>true, 'data'=>$result]);
       // return new Response();
    }


/**
     * @Route("/details/{id}", name="details")
     */
    public function VwDetailsActivite(int $id){
        $activite = $this->activiteRepo->findOneBy(["id"=>$id]);
        return $this->render('activite/details.html.twig', [
            'controller_name' => 'ActiviteController',
            'activityName'=>$activite->getNom(),
            'activityid'=>$activite->getId()
        ]);
    }


    /**
     * @Route("/AddDetails", name="AddDetails")
     */
    public function AddDetails(Request $value, BrancheRepository $rpBranche){

        try{

       
        $data =  $value->request->get('value');
        $details = new DETAILS();
        $details->setLibelle($data["Nom"])
                ->setDeroulement($data["Deroulement"])
                ->setObjectif($data["Objectif"])
                ->setDate(new \DateTime($data["Date"]))
                ->setHeuredebut(new \DateTime($data["HeureDebut"]))
                ->setHeureFin(new \DateTime($data["HeureFin"]))
                ->setResponsableActivite($data["Responsable"])
                ->setContact($data["Contact"])
                ->setBactif(1)
                ->setStatut(1)
                ->setCible($data["Cible"])
                ->setDescription("dddd")
                ->setDateCreation(new \DateTime());

        //set activity
        $activite = $this->activiteRepo->findOneBy(["id"=>$data["Activity"]]);
      //dump($data["Activity"]);
        $details->setActivite($activite);
        //set branche
        $branche = $rpBranche->findOneBy(["id"=>$data["Branche"]]);
        $details->setBranche($branche);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($details);
        $manager->flush();
        return new JsonResponse(['ok'=>true, 'data'=>"Opération effectuée avec succès"]);
    }catch(\Exception $e)
    {
     return new JsonResponse(['ok'=> false, 'message'=>$e->getMessage()]);
    }   
    } 

 /**
     * @Route("/redirectToProgramme", name="redirectToProgramme")
     */
    public function redirectToProgramme(Request $request)
    {
        $data= $request->query->get("value");
        $url = "/ProgrammesByActivite/".$data;
        return new JsonResponse(['ok'=>true, 'url'=>$url]);
    }



    /**
     * @Route("/ProgrammesByActivite/{id}", name="ProgrammesByActivite")
     */
    public function ListProgramme(Request $request, ACTIVITESRepository $rpActivite, int $id)
    {
        dump($id);
        $bEmpty = false;
        $data= $request->query->get("value");
        //get activite name
        $activite = $rpActivite->findOneBy(["id"=>$id]);
        dump($activite);
        //obtenir la liste des activités
        $qClass = new QueryClass($this->em);
        $result = $qClass->GetAllProgrammesByActivite($id);
        if(!empty($result)){
            $bEmpty = true;
        }
        return $this->render('activite/ListProgramme.html.twig', [
            'controller_name' => 'ActiviteController',
            'emptyCheck'=>$bEmpty,
            'acitivityName'=>$activite->getNom(),
            'activityid'=>$id,
            'allProgrammes'=>$result
        ]);
    }
    /**
     * @Route("/ConsulterDetails/{id}", name="ConsulterDetails")
     */
    public function ConsulterDetails(int $id, DETAILSRepository $rpDetails)
    {
        $activity = $rpDetails->findOneBy(["id"=>$id]);
        dump($activity);
        return $this->render('activite/consulterdetails.html.twig', [
            'controller_name' => 'ActiviteController',
            'detailsActivite'=>$activity           
        ]);
    }




    




    
}
