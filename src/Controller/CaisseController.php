<?php

namespace App\Controller;

use App\Entity\CaisseGroupe;
use App\Entity\CaisseDistrict;
use App\Entity\MouvementGroupe;
use App\Repository\DistrictRepository;
use App\Repository\TypeMouvementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CaisseController extends AbstractController
{

    private $ValueSession ;
    private $districtRepo;
    function __construct(SessionInterface $session, DistrictRepository $district)
    {
        $this->ValueSession= $session;
        $this->districtRepo = $district;
    }

    /**
     * @Route("/caisse", name="caisse")
     */
    public function index(): Response
    {
        return $this->render('caisse/index.html.twig', [
            'controller_name' => 'CaisseController',
        ]);
    }


      /**
     * @Route("/CreerCaisse", name="CreerCaisse")
     */
    public function CreerCaisse(): Response
    {
        return $this->render('caisse/Caisse.html.twig', [
            'controller_name' => 'CaisseController',
        ]);
    }

    
       /**
     * @Route("/VwOperations", name="VwOperations")
     */
    public function VwOperations(): Response
    {
        return $this->render('caisse/Operations.html.twig', [
            'controller_name' => 'CaisseController',
        ]);
    }

      /**
     * @Route("/ListeOperations/{origine}", name="ListeOperation")
     */
    public function GetListeOperation(int $origine, CaisseGroupe $caissegroupe, CaisseDistrict $caissedistrict) :JsonResponse
    {
        // 1 => district
       //  2 => groupe

        if($origine==1)
        {
           // $result = 
        }
        else
        {

        }

        return new JsonResponse();
    }
      /**
     * @Route("/ListeMvt", name="ListeMvt")
     */
    public function GetListeTypeMouvement(TypeMouvementRepository $typemouvement, SerializerInterface $serializer)
    {
        $liste = $typemouvement->findAll();
       $result =  $serializer->serialize($liste, 'json');
       return new JsonResponse(['ok' => true, 'data' => $result]);
    }


        /**
     * @Route("/SaveMvt", name="SaveMvt")
     */
    public function SaveMvt(Request $req, TypeMouvementRepository $typemvt)   
    {
        $entite = $this->ValueSession->get("entite");
        $value = $req->request->get("data");
        dump($this->ValueSession->get("districtid"));
        if($entite=="1")//groupe
        {
            
        }
        else //distrit
        {
            $districtid = $this->ValueSession->get("districtid");
            $mvt = new MouvementGroupe();
            $mvt->setTypemouvement($typemvt->findOneBy(["id"=>$value["type"]]))
                ->setdescription($value["description"])
                ->setmontant($value["montant"])
                //->setdatemouvement($value["date"])
                ->setdistrict($this->districtRepo->findOneBy(["id"=>$districtid]));
        }
        return new Response();
    }

}
