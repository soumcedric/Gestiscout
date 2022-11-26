<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Classes\QueryClass;
use App\Entity\Responsable;
use App\Entity\ResponsableFormation;
use App\Entity\SessionFormation;
use App\Entity\SessionFormationResponsable;
use App\Repository\FormationRepository;
use App\Repository\ResponsableFormationRepository;
use App\Repository\ResponsableRepository;
use App\Repository\SessionFormationRepository;
use App\Repository\SessionFormationResponsableRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class FormationController extends AbstractController
{

    private $em;
    private $repoStage;
    function __construct(EntityManagerInterface $em, FormationRepository $repformation)
    {
        $this->em=$em;
        $this->repoStage = $repformation;
        
    }

    /**
     * @Route("/formation", name="formation")
     */
    public function index(): Response
    {
        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
        ]);
    }

    /**
     * @Route("/chefparformation", name="chefparformation")
     */
    public function ChefParFormation(){
        return $this->render('formation/chefparformation.html.twig');
    }
    /**
     * @Route("/ListeChefByChef", name="ListeChefByChef")
     */
    public function ListeChefByChef(Request $request)
    {
        $groupe = $request->query->get("groupe");
        $stage = $request->query->get("stage");
        $qClass = new QueryClass($this->em);
        $liste = $qClass->GetChefByFormation($groupe,$stage);
        return new JsonResponse(["ok"=>true, "data"=>$liste]);
    }

   /**
     * @Route("/PrevisionStage", name="PrevisionStage")
     */
    public function PrevisionStage()
    {
         return $this->render('formation/previsionstage.html.twig');
    }



    /**
     * @Route("/GetNextParticpation", name="GetNextParticpation")
     */
    public function GetNextParticpation(Request $request)
    {
        $stage = $request->query->get("value");
      
          $qClass = new QueryClass($this->em);
          $liste = $qClass->GetNextStageFormation($stage);
          return new JsonResponse(["ok"=>true , "data"=>$liste]);
    }


     /**
     * @Route("/CreerSession", name="CreerSessionFormation")
     */
    public function CreerSessionFormation()
    {
         return $this->render('formation/CreerSessionFormation.html.twig');
    }

    /**
     * @Route("/SaveSession", name="SaveSession")
     */
    public function SaveSession(Request $request, FormationRepository $formation) : JsonResponse
    {
        try
        {
           
            $data = $request->request->get("value");
            $sessionToCreate = new SessionFormation();
            $sessionToCreate->setLieu($data["Lieu"])
                            ->setDirecteurStage($data["DirecteurStage"])
                            ->setDateDebut(new \DateTime($data["DateDebut"]))
                            ->setDateFin(new \DateTime($data["DateFin"]))
                            ->setStageFormation($this->repoStage->findOneBy(["id"=>$data["SelectedStage"]]));
   
           $this->em->persist($sessionToCreate);
           $this->em->flush();
           return new JsonResponse(['ok' => true, 'message' => 'opération effectuée avec succès']);
        }
        catch(\Exception $e )
        {
            return new JsonResponse(['ok' => false, 'message' => $e->getMessage()]);
        }

       // return new Response();
       
    }


      /**
     * @Route("/Sessions", name="Sessions")
     */
    public function Sessions(SessionFormationRepository $repoSession, SerializerInterface $serializer) : JsonResponse
    {
        try
        {
          // $liste = $repoSession->findBy(array(),array("id"=> "DESC"));
          $qClass = new QueryClass($this->em);
          $liste = $qClass->GetSessions();
           $listeSession =  $serializer->serialize($liste, 'json');
          // dump($listeSession);
          return new JsonResponse(['ok' => true, 'data' => $listeSession]);
        }
        catch(\Exception $e )
        {
            return new JsonResponse(['ok' => false, 'data' => $e->getMessage()]);
        }

       // return new Response();
       
    }


       /**
     * @Route("/ListePreparatoire", name="ListePreparatoire")
     */
    public function ListePreparatoire(Request $request, SessionFormationRepository $repoSession, SerializerInterface $serializer, FormationRepository $repoFormation, ResponsableFormationRepository $repformationrespo) 
    {
        try
        {
          //Get Session Id
          $sessionId = $request->request->get("value");
          //Get Formation
          $session = $repoSession->findOneBy(["id"=>$sessionId]);
          
          $formation = $session->getStageFormation();
         
          //Get formation's order
          $order = $repoFormation->findOneBy(["id"=>$formation->getId()])->getOrdre();
          
          //Get Responsable's list with order = currentorder-1
          $orderToConsider = $order-1;
          $formationToConsider = $repoFormation->findOneBy(["ordre"=>$orderToConsider]);
          //dump($formationToConsider);
        //   $listeformationresponsableToConsider = $repformationrespo->findBy(array('formation_id'=>$formationToConsider->getId()));
        //   foreach(listeformationresponsableToConsider as $value)
        //   {

        //   }
          $qClass = new QueryClass($this->em);
          $listeResponsable = $qClass->GetListParticipantformation($formationToConsider->getId());
          //dump($listeResponsable);
        // return new JsonResponse(['ok' => true, 'data' => $serializer->serialize($listeResponsable,'json')]);
        return new JsonResponse(['ok' => true, 'data' => $listeResponsable, 'idFormation'=>$session->getId()]);
        }
        catch(\Exception $e )
        {
            return new JsonResponse(['ok' => false, 'data' => $e->getMessage()]);
        }

        //return new Response();
       
    }

    /**
     * @Route("/CreerListeParticipant", name="CreerListeParticipant")
     */
    public function CreerListeParticipant(Request $request, ResponsableRepository $repoResponsable, SessionFormationRepository $repoSessionFormation): JsonResponse
    {
        try{

       
        $participants = $request->request->get("value");
        $idsession = $request->request->get("idsession");
        //get session concerned
        $session = $repoSessionFormation->findOneBy(["id"=>$idsession]);
        
        foreach($participants as $value)
        {
            //get responsable 
            $responsable = $repoResponsable->findOneBy(["id"=>$value]);
            $sessionFormationResponsableToAdd = new SessionFormationResponsable();
            $sessionFormationResponsableToAdd->setSessionId($session)
                                             ->setResponsableId($responsable)
                                             ->setBinscrit(true)
                                             ->setDateCreation(new \DateTime())
                                             ->setBconfirmPariticpation(false);
                                             $this->em->persist($sessionFormationResponsableToAdd);
                                           
        }
        $this->em->flush();
        return new JsonResponse(['ok' => true, 'data' => "Opération effectuée avec succès"]);
    }
    catch(\Exception $e)
    {
        return new JsonResponse(['ok' => false, 'data' => $e->getMessage()]);
    }
        //return new Response();
    }

    
    /**
     * @Route("/ListResponsableNextSession", name="ListResponsableNextSession")
     */
    public function GetResponsableBy_nextSession(SessionFormationResponsableRepository $sessionFormationResp, ResponsableRepository $responsableRepo, Request $request, SerializerInterface $serializer) :JsonResponse
    {
        try{
            $sessionid = $request->request->get("sessionid");
            $sessionSelected = $sessionFormationResp->findBy(array("sessionId"=>$sessionid));
            // $responsables = array();
            // foreach($sessionSelected as $respo){
            //     //$responsables($respo->getResponsableId());
            //     $responsable = $responsableRepo->findOneBy((["id"=>$respo->getResponsableId()->getId()]));
            //     array_push($responsables,$responsable);
            // }
            // $responsableToDisplay = array();

            $qClass = new QueryClass($this->em);
            $result = $qClass->GetResponsableBy_nextSession($sessionid);
            $liste = $serializer->serialize($result,'json');

            return new JsonResponse(['ok' => true, 'data' => $liste]); 
        }
       catch(\Exception $e)
       {
            return new JsonResponse(['ok' => false, 'data' => $e->getMessage()]);
       }
        
        //return new Response();
    }

    /**
     * @Route("/ConfirmerParticipation", name="ConfirmerParticipation")
     */
    public function ConfirmParticipation(Request $request, SessionFormationResponsableRepository $repo)
    {
        $value = $request->request->get("value");
       
        foreach($value as $val){
            //get the record according id
            $concerned = $repo->findOneBy(["id"=>$val]);
            dump($concerned);
            $concerned->setBconfirmPariticpation(true);
            $concerned->setDateModification(new \DateTime());
            $this->em->persist($concerned);

        }
        $this->em->flush();
        return new JsonResponse(['ok' => true, 'data' => "Opération effectuée avec succès"]);
    }

      /**
     * @Route("/ListeDefinitive", name="ListeDefinitive")
     */
    public function ListeDefinitive()
    {
        return $this->render('formation/ListeDefinitive.html.twig', [
            'controller_name' => 'FormationController',
        ]);
    }
}
