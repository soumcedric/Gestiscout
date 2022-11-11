<?php

namespace App\Controller;

use App\Entity\CaisseGroupe;
use App\Entity\CaisseDistrict;
use App\Repository\TypeMouvementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CaisseController extends AbstractController
{
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

}
