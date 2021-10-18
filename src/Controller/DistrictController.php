<?php

namespace App\Controller;

use App\Classes\QueryClass;
use App\Entity\District;
use App\Entity\ExercerFonction;
use App\Repository\DistrictRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DistrictController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    #[Route('/district', name: 'district')]
    public function index(): Response
    {

        return $this->render('district/index.html.twig', [
            'controller_name' => 'DistrictController'

        ]);
    }



    #[Route('/VueEnregistrement', name: 'VueEnregistrement')]
    public function VueEnregistrement(): Response
    {
        return $this->render('district/VueEnregistrementChef.html.twig', [
            'controller_name' => 'DistrictController',
        ]);
    }

    #[Route('/ListeJeuneDistrict', name: 'ListeJeuneDistrict')]
    public function ListeJeuneDistrict(): Response
    {
        return $this->render('district/ListeJeune.html.twig', [
            'controller_name' => 'DistrictController',
        ]);
    }
    #[Route('/ListeResponsableDistrict', name: 'ListeResponsableDistrict')]
    public function ListeResponsableDistrict(): Response
    {
        return $this->render('district/ListeResponsable.html.twig', [
            'controller_name' => 'DistrictController',
        ]);
    }

    #[Route('/ListeJeuneCotise', name: 'JeuneCotiseDistrict')]
    public function ListeJeuneCotise(): Response
    {
        return $this->render('district/ListeJeuneCotise.html.twig', [
            'controller_name' => 'DistrictController',
        ]);
    }


    #[Route('/RechercheJeuneByCriteria', name: 'RechercheJeuneByCriteria')]
    public  function RechercheJeuneByCriteria(Request $value,SerializerInterface $serializer)
    {
          $branche = $value->query->get('branche');
          $groupe = $value->query->get('groupe');

        $qClass = new QueryClass($this->em);
        $result = $qClass->GetListeJeuneByCriteria($groupe,$branche);
        $finalResult = $serializer->serialize($result,'json');
        if($result!=null)
            return new Response($finalResult,200);
        else
            return new Response(null,200);
    }

    #[Route('/RechercheResponsable', name: 'RechercheResponsable')]
    public  function RechercheResponsableByCriteria(Request $value,SerializerInterface $serializer)
    {

        $groupe = $value->query->get('groupe');

        $qClass = new QueryClass($this->em);
        $result = $qClass->GetListeResponsableByCriteria($groupe);
        $finalResult = $serializer->serialize($result,'json');
        if($result!=null)
            return new Response($finalResult,200);
        else
            return new Response("",200);
    }


    #[Route('/RechercheCotise', name: 'RechercheCotise')]
    public  function RechercheCotiseDistrictByCriteria(Request $value,SerializerInterface $serializer)
    {
        $branche = $value->query->get('branche');
        $groupe = $value->query->get('groupe');
      //  var_dump($groupe);
        $type = $value->query->get('type');

        $qClass = new QueryClass($this->em);
        if ($type=="1")
        {
            //recherche des jeunes cotisés
            $result = $qClass->GetListeJeuneCotiseByCriteria($groupe,$branche);
        }else
        {
            //recherche des responsables cotisés
            $result = $qClass->GetListeRespoCotiseByCriteria($groupe);
        }

        $finalResult = $serializer->serialize($result,'json');
        if($result!=null)
            return new Response($finalResult,200);
        else
            return new Response("",200);
    }
    #[Route('/ListeResponsable_District', name: 'ListeResponsable_District')]
    public function ListeResponsable_District(): Response
    {
        return $this->render('district/ListeResponsableDistrict.html.twig', [
            'controller_name' => 'DistrictController',
        ]);

    }

    #[Route('/ListeResponsableCotiseDistrict', name: 'ListeResponsableCotiseDistrict')]
    public function ListeResponsableCotiseDistrict(): Response
    {
        return $this->render('district/ListeResponsableCotise.html.twig', [
            'controller_name' => 'DistrictController',
        ]);

    }


    #[Route('/ListeMembreDistrict', name: 'ListeMembreDistrict')]
    public function ListeMembreDistrict(SerializerInterface $serializer, DistrictRepository $districtRepo): Response
    {
        $ListeMembre = $districtRepo->findAll();
        //var_dump($ListeMembre);
        $result = $serializer->serialize($ListeMembre,'json',["groups"=>"district"]);
       return  new Response($result,200);
    }



    #[Route('/AddResponsableDistrict', name: 'AddResponsableDistrict')]
    public function AddResponsableDistrict(): Response
    {
        return $this->render('district/AddResponsableDistrict.html.twig', [
            'controller_name' => 'DistrictController',
        ]);
    }



    #[Route('/InsertRespoDistrict', name: 'InsertRespoDistrict')]
    public function InsertRespoDistrict(Request $value)
    {
        $Req = $value->request->get('value');
        $date= new \DateTime($Req["dob"]);
        $district = new District();
        $district->setNom($Req["nom"])
                 ->setPrenoms($Req["prenoms"])
                 ->setTelephone($Req["telephone"])
                ->setDob($Req["dob"]);
        $exercerfonction = new ExercerFonction();
        $exercerfonction->setDateDebut(new \DateTime())
                        ->setDateFin(new \DateTime())
                        ->setDateCreation(new \DateTime())
                        ->addDistrict($district);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($district);
        $manager->persist($exercerfonction);
        $manager->flush();
        return new Response(true,200);

    }
}
