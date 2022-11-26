<?php

namespace App\Controller;

use App\Entity\Periode;
use App\Classes\QueryClass;
use App\Entity\CaisseGroupe;
use Doctrine\ORM\Mapping\Id;
use App\Entity\CaisseDistrict;
use App\Entity\Evenement;
use App\Entity\MouvementGroupe;
use Doctrine\ORM\EntityManager;
use App\Entity\MouvementDistrict;
use App\Entity\TresorerieActivite;
use App\Repository\UserRepository;
use App\Repository\PeriodeRepository;
use App\Repository\DistrictRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TypeMouvementRepository;
use App\Repository\CaisseDistrictRepository;
use App\Repository\EvenementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\MouvementDistrictRepository;
use App\Repository\TresorerieActiviteRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CaisseController extends AbstractController
{

    private $ValueSession;
    private $districtRepo;
    private $userRepo;
    private $entityManager;
    private $periodeRepo;
    private $caisseDistrictRepo;
    private $qclass;
    function __construct(
        SessionInterface $session,
        DistrictRepository $district,
        UserRepository $user,
        EntityManagerInterface $em,
        PeriodeRepository $periode,
        CaisseDistrictRepository $caissedistrict
    ) {
        $this->ValueSession = $session;
        $this->districtRepo = $district;
        $this->userRepo = $user;
        $this->entityManager = $em;
        $this->periodeRepo = $periode;
        $this->caisseDistrictRepo = $caissedistrict;

        $this->qclass = new QueryClass($em);
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
     * @Route("/ListeOperations", name="ListeOperations")
     */
    public function GetListeOperation(MouvementDistrictRepository $mvtRepo, SerializerInterface $serializer, TypeMouvementRepository $typemvtRepo): JsonResponse
    {
        // 1 => district
        //  2 => groupe
        $entite = $this->ValueSession->get("entite");
        if ($entite == 1) //groupe
        {
            // $result = 
        } else //district
        {

            $district = $this->ValueSession->get("districtid")->getId();

            $operationDistrict = $this->qclass->GetMouvementDistrict($district);

            //get solde caisse
            $solde = $this->caisseDistrictRepo->findOneBy(["district" => $district])->getSolde();
            return new JsonResponse(['ok' => true, 'data' => $operationDistrict]);
        }

        // return new Response();
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
    public function SaveMvt(Request $req, TypeMouvementRepository $typemvt, DistrictRepository $dis): JsonResponse
    {
        $entite = $this->ValueSession->get("entite");
        $value = $req->request->get("data");

        if ($entite == "1") //groupe
        {
            return new JsonResponse();
        } else //distrit
        {
            $district = $this->ValueSession->get("districtid")->getId();
            //get typemouvement id from code
            $typemouvement = $typemvt->findOneBy(["Code" => $value["type"]]);
            $mvt = new MouvementDistrict();
            $mvt->setTypemouvement($typemouvement)
                ->setDescription($value["description"])
                ->setmontant($value["montant"])
                ->setDateMvt(new \DateTime($value["date"]))
                ->setUser($this->userRepo->findOneBy(["id" => $this->ValueSession->get("id")]))
                ->setdistrict($this->districtRepo->findOneBy(["id" => $district]))
                ->setDatecreate(new \DateTime())
                ->setCaisse($this->caisseDistrictRepo->findOneBy(["id" => 1]))
                ->setPeriode($this->periodeRepo->findOneBy(["id" => 1]))
                ->setUsercreate($this->ValueSession->get("id"));


            //mise à jour du solde de ce district
            //get solde district
            $soldeDistrict = $this->caisseDistrictRepo->findOneBy(["district" => $district]);
            if ($soldeDistrict != null) {
                $solde = $soldeDistrict->getSolde();
                $soldeDistrict->setSolde($solde + ($mvt->getMontant()));
                $soldeDistrict->setDateSolde(new \DateTime());
                $soldeDistrict->setDatecreate(new \DateTime());


                $this->entityManager->persist($mvt);
                $this->entityManager->persist($soldeDistrict);
                $this->entityManager->flush();
            }

            return new JsonResponse(["ok" => true, "message" => "opération effectuée avec succès"]);
        }

        // return new Response();
    }



    /**
     * @Route("/Solde", name="Solde")
     */
    public function Solde(): JsonResponse
    {
        // 1 => district
        //  2 => groupe
        $entite = $this->ValueSession->get("entite");
        if ($entite == 1) //groupe
        {
            // $result = 
        } else //district
        {

            $district = $this->ValueSession->get("districtid")->getId();
            //get solde caisse
            $solde = $this->caisseDistrictRepo->findOneBy(["district" => $district])->getSolde();
            return new JsonResponse(['ok' => true, 'solde' => $solde]);
        }

        // return new Response();
    }

    /**
     * @Route("/Evenement", name="Evenement")
     */
    public function Evenement(): Response
    {
        return $this->render('caisse/Evenement.html.twig', [
            'controller_name' => 'CaisseController',
        ]);
    }

    #[Route('/GetEvenements', name: 'GetEvenements')]
    public function GetListEvenement()
    {
        $entiteId = 0;
        // 1 => groupe
        //  2 => district
        $entite = $this->ValueSession->get("entite");
        if ($entite == 2) {
            $entiteId =  $this->ValueSession->get("districtid")->getId();
        } else {
            $entiteId = $this->ValueSession->get("groupeid")->getId();
        }
        //    dump($entite);
        dump($entiteId);
        $liste = $this->qclass->GetEvenements($entiteId);
        return new JsonResponse(["ok" => true, "data" => $liste]);
        // return new Response();
    }



    /**
     * @Route("/SaveEvent", name="SaveEvent")
     */
    public function SaveEvent(Request $req, DistrictRepository $dis)
    {
        $entite = $this->ValueSession->get("entite");
        $value = $req->request->get("data");

        if ($entite == "1") //groupe
        {
            return new JsonResponse();
        } else //distrit
        {
            $district = $this->ValueSession->get("districtid")->getId();

            $event = new Evenement();
            $event->setLibelle($value["libelle"])
                ->setDateCreation(new \DateTime())
                ->setEntite(2)
                ->setIdEntite($district)
                ->setUserCreation(0);

            $this->entityManager->persist($event);
            $this->entityManager->flush();
            $lastId = $event->getId();

            //création de la caisse de l'évènement
            $caisseEvent = new TresorerieActivite();
            $caisseEvent->setEventId($lastId)
                ->setSolde(0)
                ->setDateSolde(new \DateTime())
                ->setUserCreation(0)
                ->setDateCreation(new \DateTime());


            $this->entityManager->persist($caisseEvent);
            $this->entityManager->flush();
            return new JsonResponse(["ok" => true, "message" => "opération effectuée avec succès avec création de la caisse de l'activité"]);
        }
        //return new Response();


    }


    /**
     * @Route("/MouvementEvenement", name="MouvementEvenement")
     */
    public function MouvementEvenement(): Response
    {
        return $this->render('caisse/MouvementEvenement.html.twig', [
            'controller_name' => 'CaisseController',
        ]);
    }


        /**
     * @Route("/MouvementsByEvent/{eventId}", name="MouvementsByEvent")
     */
    public function MouvementsByEvent($eventId,TresorerieActiviteRepository $treso, EvenementRepository $event): JsonResponse
    {
        $entiteId = 0;
        // 1 => district
        //  2 => groupe
        $entite = $this->ValueSession->get("entite");
        if ($entite == 1) //groupe
        {
            $entiteId = $this->ValueSession->get("groupeid")->getId();
        } 
        else //district
        {

            $entiteId = $this->ValueSession->get("districtid")->getId();
        }

            $mouvements = $treso->findBy(["evenement"=>$event->findOneBy(["id"=>$entiteId])]);

            //get solde caisse
          //  $solde = $this->caisseDistrictRepo->findOneBy(["district" => $district])->getSolde();
            //return new JsonResponse(['ok' => true, 'data' => $operationDistrict]);
    

         return new Response();
    }


}
