<?php

namespace App\Controller;

use App\Classes\QueryClass;
use App\Entity\Cotisation;
use App\Repository\AnneePastoraleRepository;
use App\Repository\JEUNERepository;
use App\Repository\ResponsableRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

class CotisationController extends AbstractController
{




    private $JeuneLayer;
    private $AnneeLayer;
    private $em;
    private $RespoLayer;
    public function __construct(JEUNERepository $jeune, AnneePastoraleRepository $annee, EntityManagerInterface $em,ResponsableRepository  $respo)
    {

        $this->JeuneLayer=$jeune;
        $this->AnneeLayer=$annee;
        $this->em=$em;
        $this->RespoLayer=$respo;



    }





    #[Route('/cotisation', name: 'cotisation')]
    public function index(): Response
    {
        return $this->render('cotisation/CotisationJeune.html.twig', [
            'controller_name' => 'CotisationController',
        ]);
    }


    #[Route('/cotisationResponsable', name: 'cotisationResponsable')]
    public function indexCotisationResponsable(): Response
    {
        return $this->render('cotisation/CotisationResponsable.html.twig', [
            'controller_name' => 'CotisationController',
        ]);
    }

    #[Route('/ViewJeuneCotise', name: 'ViewJeuneCotise')]
    public function ViewJeuneCotise(): Response
    {
        return $this->render('cotisation/ViewJeuneCotise.html.twig', [
            'controller_name' => 'CotisationController',
        ]);
    }

    #[Route('/ViewResponsableCotise', name: 'ViewResponsableCotise')]
    public function ViewResponsableCotise(): Response
    {
        return $this->render('cotisation/ViewResponsableCotise.html.twig', [
            'controller_name' => 'CotisationController',
        ]);
    }



    #[Route('/cotisationJeune', name: 'cotisationJeune')]
    public function CotisationJeune(SessionInterface $session,SerializerInterface $serializer): JsonResponse
    {

        try
        {
            $Idgroupe = $session->get('groupeid');
            $ActiveYear = $this->AnneeLayer->findActiveYear();
            $qClass = new QueryClass($this->em);
            $jeune = $qClass->GetListeJeuneNonCotise($Idgroupe->getId());
            dump($jeune);
            $result = $serializer->serialize($jeune,'json',['groups'=>'read']);
            return new JsonResponse(["ok"=>true, "data"=>$result]);
        }
        catch(\Exception $e)
        {
            return new JsonResponse(['ok'=> false, 'message'=>$e->getMessage()]);
        }
  
    }


    #[Route('/SaveCotisation', name: 'SaveCotisation')]
    public function SaveCotisation(SessionInterface $session,
                             \Symfony\Component\HttpFoundation\Request $request,AnneePastoraleRepository $annee)
    {
        try{
            $activeYear = $annee->findActiveYear();

            // Read inputs directly (no JSON/quote normalization)
            $matricule = $request->request->get('value');
            $JeuneId = $request->request->get('JeuneId');
             
            
            // Minimal trimming for whitespace
            $matricule = $matricule !== null ? trim((string)$matricule) : null;
            $JeuneId = $JeuneId !== null ? trim((string)$JeuneId) : null;

            if (empty($JeuneId) || $matricule === null || $matricule === '') {
                return new JsonResponse(["Ok"=>false,"message"=>"Paramètres manquants"], Response::HTTP_BAD_REQUEST);
            }
            
            // find jeune (works for int id or uuid)
            $Jeune = $this->JeuneLayer->findOneById($JeuneId);
            if (!$Jeune) {
                return new JsonResponse(["Ok"=>false,"message"=>"Jeune introuvable"], Response::HTTP_NOT_FOUND);
            }
           
            // prevent duplicate
            // $existing = $this->em->getRepository(Cotisation::class)->findOneBy(['jeune' => $Jeune, 'anneePastorale' => $activeYear]);
            // dump($existing);
            // if ($existing) {
            //     return new JsonResponse(["Ok"=>false,"message"=>"Cotisation déjà existante pour ce jeune cette année"], Response::HTTP_CONFLICT);
            // }
      
            $cotisation = new Cotisation();
           $cotisation->setMatricule($matricule)
                ->setJeune($Jeune)
                ->setResponsable(null)
                 ->setUserCreation('Admin')
                 ->setAnneePastorale($activeYear[0])
                 ->setDateCreation(new \DateTime());
            
           $this->em->persist($cotisation);
            $this->em->flush();

            return new JsonResponse(["ok"=>true,"message"=>"Opération réussie"], Response::HTTP_CREATED);
        }
        catch (\Exception $e){
            return new JsonResponse(["ok"=>false,"message"=>$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }



    #[Route('/GetListJeuneCotise', name: 'GetListJeuneCotise')]
    public function GetListJeuneCotise(SessionInterface $session,SerializerInterface $serializer): Response
    {

        $Idgroupe = $session->get('groupeid');
        // $jeune=$this->JeuneLayer->GetJeuneCotise((int)$Idgroupe->getId());
        $qClass = new QueryClass($this->em);
        $jeune = $qClass->GetListeJeuneCotiseParGroupe($Idgroupe->getId());
        $result = $serializer->serialize($jeune,'json',['groups'=>'read']);
        return new JsonResponse(["ok"=>true, "data"=>$result]);
    }

    #[Route('/GetListeJeuneCotiseParGroupe', name: 'GetListeJeuneCotiseParGroupe')]
    public function GetListeJeuneCotiseParGroupe(SessionInterface $session,SerializerInterface $serializer)
    {
        $activeYear = $this->AnneeLayer->findActiveYear();
        $Idgroupe = $session->get('groupeid');
        $Qclass = new QueryClass($this->em);
        $Jeunes = $Qclass->GetListeJeuneCotiseParGroupe($Idgroupe->getId());
        $liste = $serializer->serialize($Jeunes,'json',['groups'=>'read']);
        return new JsonResponse(["ok"=>true, "data"=>$liste]);
    }


    #[Route('/GetListeRespoNonCotise', name: 'GetListeRespoNonCotise')]
    public function GetListeRespoNonCotise(SessionInterface $session,SerializerInterface $serializer): Response
    {

        $Idgroupe = $session->get('groupeid');
        $ActiveYear = $this->AnneeLayer->findActiveYear();
        $qClass = new QueryClass($this->em);
        $jeune = $qClass->GetResponsablesNonCotiseParGroupe($Idgroupe->getId());
        //dump($jeune);
       // var_dump($jeune);
        $result = $serializer->serialize($jeune,'json',['groups'=>'show_chef']);
        return new JsonResponse(["ok"=>true, "data"=>$result]);
       // return new Response();
    }



    #[Route('/SaveCotisationResponsable', name: 'SaveCotisationResponsable')]
    public function SaveCotisationResponsable(SessionInterface $session, \Symfony\Component\HttpFoundation\Request $request,AnneePastoraleRepository $annee): Response
    {

        try{
            $activeYear = $annee->findActiveYear();
            $cotisation = new Cotisation();
            $matricule = $request->request->get('value');
            $RespoId = $request->request->get('RespoId');
            dump($RespoId);
            //get jeune information
            $Respo = $this->RespoLayer->findOneBy(["id"=>$RespoId]);
            $cotisation->setMatricule($matricule)
                ->setResponsable($Respo)
                ->setUserCreation('Admin')
                ->setAnneePastorale($activeYear[0])
                ->setDateCreation( new \DateTime());

            
            $this->em->persist($cotisation);
            $this->em->flush();
            return new JsonResponse(["ok"=>true,"message"=>"Opération réussie"]);
        }
        catch (\Exception $e){
            return new JsonResponse(["ok"=>false,"message"=>$e->getMessage()]);
        }
    }


    #[Route('/GetListeRespoCotise', name: 'GetListeRespoCotise')]
    public function GetListeRespoCotise(SessionInterface $session,SerializerInterface $serializer): Response
    {

        $Idgroupe = $session->get('groupeid');
        $ActiveYear = $this->AnneeLayer->findActiveYear();
        $qClass = new QueryClass($this->em);
        $jeune = $qClass->GetListResponsablesCotisesParGroupe($Idgroupe->getId());
        
        $result = $serializer->serialize($jeune,'json',['groups'=>'show_chef']);
        return new JsonResponse(["ok"=>true, "data"=>$result]);
    }

}
