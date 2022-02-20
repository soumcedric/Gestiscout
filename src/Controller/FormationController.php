<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Classes\QueryClass;
use Symfony\Component\HttpFoundation\Request;
class FormationController extends AbstractController
{

    private $em;
    function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
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


}
