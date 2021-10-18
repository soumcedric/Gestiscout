<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\entity\ACTIVITES;
use App\Entity\Groupe;
use App\Repository\ACTIVITESRepository;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\BrancheRepository;
use App\Repository\GroupeRepository;

class ActiviteController extends AbstractController
{
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
                  ->setStatut($data["Statut"])
                  ->setAutorisation($data["Autorisation"])
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
    public function ListActivites(ACTIVITESRepository $rpActivite)
    {
       $activites = $rpActivite->findAll();
     //  $result = $serializer->serialize($activites,'json',['groups' => 'fonction']);
       return new JsonResponse(['ok'=>true, 'data'=>$activites]);
    }

}
