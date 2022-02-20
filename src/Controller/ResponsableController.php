<?php

namespace App\Controller;

use App\Classes\QueryClass;
use App\Repository\GenreRepository;
use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use MongoDB\Driver\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ResponsableRepository;
use App\Repository\ExercerFonctionRepository;
use App\Repository\AnneePastoraleRepository;
use App\Repository\FONCTIONRepository;
use App\Entity\Responsable;
use App\Entity\ExercerFonction;
use App\Entity\AnneePastorale;
use App\Repository\FormationRepository;
use App\Repository\ResponsableFormationRepository;
use App\Entity\ResponsableFormation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;


class ResponsableController extends AbstractController
{
    private $em;
    private $AnneeLayer;
    function  __construct(EntityManagerInterface $em, AnneePastoraleRepository $annee)
    {
        $this->em=$em;
        $this->AnneeLayer=$annee;
    }

    #[Route('/responsable', name: 'responsable')]
    public function index(): Response
    {
        return $this->render('responsable/index.html.twig', [
            'controller_name' => 'ResponsableController',
        ]);
    }

    #[Route('/AjouterRespoView', name: 'AjouterRespoView')]
    public function AjouterRespoView(): Response
    {
        return $this->render('responsable/AddResponsable.html.twig', [
            'controller_name' => 'ResponsableController',
        ]);
    }

    #[Route('/GetListResponsable', name: 'GetListResponsable')]
    public function GetListResponsable(SessionInterface $session,ExercerFonctionRepository  $exercerRepo,ResponsableRepository  $repoResponsable, SerializerInterface $serializer,AnneePastoraleRepository $anneerepo, FONCTIONRepository $fonctionrepo)
    {
        $groupe = $session->get('groupeid');
        $ActiveYear = $this->AnneeLayer->findActiveYear();
        $qCls = new QueryClass($this->em);
        $id = $groupe->getId();
        $ListResponsable =$qCls->GetResponsableActifByGroupe($id);
        $result = $serializer->serialize($ListResponsable,'json',   ['groups' => 'show_chef']);
        return new Response($result,200);

    }



    #[Route('/GetListResponsableDistrict', name: 'GetListResponsableDistrict')]
    public function GetListResponsableDistrictActif(SessionInterface $session,ExercerFonctionRepository  $exercerRepo,ResponsableRepository  $repoResponsable, SerializerInterface $serializer,AnneePastoraleRepository $anneerepo, FONCTIONRepository $fonctionrepo)
    {
        $Idgroupe = $session->get('groupeid');
        $ActiveYear = $this->AnneeLayer->findActiveYear();
        $qCls = new QueryClass($this->em);
        $ListResponsable =$qCls->GetListResponsableDistrictActif("",$ActiveYear[0]->getId());
        foreach ($ListResponsable as $respo)
        {
            $dateOfBirth = $respo->getDob();
            $respo->setDateNaiss($dateOfBirth->format('d-m-Y'));
        }




        $result = $serializer->serialize($ListResponsable,'json',   ['groups' => 'show_chef']);
        return new Response($result,200);

    }



    #[Route('/AddResponsable', name: 'AddResponsable')]
    public function AddResponsable(GenreRepository $genrerepo,SessionInterface $session,Request $value,ResponsableRepository $repoRespo, FONCTIONRepository $repoFonction, AnneePastoraleRepository $repoAnnee,GroupeRepository  $groupeRepo, FormationRepository $formrepo, ResponsableFormationRepository $rfrepo)
    {

        try
        {



            $lastid = $repoRespo->findBy(array(),array('id'=>'DESC'),1,0);

            $id=0;
            if($lastid == null)
            {
                $id = 1;
            }
            else
            {
                $id =  $lastid[0]->getId()+1;
            }
            $fromJson=$value->request->get('value');
            //get formation
            $formation = $formrepo->findOneBy(['id'=>$fromJson["formation"]]);


             //new responsable formation
             $responsableformation = new ResponsableFormation();
             $responsableformation->setFormationId($formation)
                                  ->setDatecreation(new \DateTime());
            if ($fromJson['groupe'] == null){

                $groupeId= $session->get('groupeid');
                $connectedGroupe = $groupeRepo->findGroupeById($groupeId->getId());
                $responsable = new Responsable();
                $ExerciceFonction = new ExercerFonction();
                $idFonction = $fromJson["fonction"];
                $genre =  $genrerepo->findOneBy(["id"=>$fromJson["genre"]]);
              
               

                $date = new \DateTime($fromJson["dob"]);
                $responsable->setNom($fromJson["nom"])
                    ->setId($id)
                    ->setPrenoms($fromJson["prenoms"])
                    ->setHabitation($fromJson["habitation"])
                    ->setOccupation($fromJson["occupation"])
                    ->setTelephone($fromJson["telephone"])
                    ->setDateCreation(new \DateTime())
                    ->setDob($date)
                    ->setGenre($genre)
                    ->setUserCreation("Admin")
                    ->setUserModification("Admin")
                    ->setStatut(1)
                   // ->addFormation($formation)
                 //  ->addResponsableFormation($responsableformation)
                    ->setGroupe($connectedGroupe[0]);
                    $responsableformation->setResponsableId($responsable);

                    $responsable->addResponsableFormation($responsableformation);
                $fonction = $repoFonction->findById($idFonction);

                $anneePastorale = $repoAnnee->findActiveYear();
                $ExerciceFonction->setFonction($fonction[0])
                    ->setAnneePastorale($anneePastorale[0])
                    ->setDateCreation(new \DateTime())
                    ->setDateDebut(new \DateTime())
                    ->setDateFin(new \DateTime())
                    ->setUserModification("Admin")
                    ->setUserCreation("Admin");

                $responsable->addExercerFonction($ExerciceFonction);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($responsable);
                $manager->flush();
           }
           else{
                //get concerned group
               $chosenGroup=$groupeRepo->findOneBy(["id"=>$fromJson['groupe']]);
                $responsable = new Responsable();
                $ExerciceFonction = new ExercerFonction();
                $idFonction = $fromJson["fonction"];
                $genre =  $genrerepo->findOneBy(["id"=>$fromJson["genre"]]);

                $date = new \DateTime($fromJson["dob"]);
                $responsable->setNom($fromJson["nom"])
                    ->setId($id)
                    ->setPrenoms($fromJson["prenoms"])
                    ->setHabitation($fromJson["habitation"])
                    ->setOccupation($fromJson["occupation"])
                    ->setTelephone($fromJson["telephone"])
                    ->setDateCreation(new \DateTime())
                    ->setDob($date)
                    ->setGenre($genre)
                    ->setUserCreation("Admin")
                    ->setUserModification("Admin")
                    ->setStatut(1)
                 //   ->addFormation($formation)
                     //->addResponsableFormation($responsableformation)
                    ->setGroupe($chosenGroup);



                    $responsableformation->setResponsableId($responsable);
                    $responsable->addResponsableFormation($responsableformation);



                $fonction = $repoFonction->findById($idFonction);
                $anneePastorale = $repoAnnee->findActiveYear();
                $ExerciceFonction->setFonction($fonction[0])
                    ->setAnneePastorale($anneePastorale[0])
                    ->setDateCreation(new \DateTime())
                    ->setDateDebut(new \DateTime())
                    ->setDateFin(new \DateTime())
                    ->setUserModification("Admin")
                    ->setUserCreation("Admin");

                $responsable->addExercerFonction($ExerciceFonction);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($responsable);
                $manager->flush();


           }

        return  new \Symfony\Component\HttpFoundation\Response(true,200);


        }
        catch (\Exception $e)
        {
            
           return  new \Symfony\Component\HttpFoundation\Response(false,200);
        }

    }
    #[Route('/supprimerResponsable', name: 'supprimerResponsable')]
    public function supprimerResponsable(ResponsableRepository  $repoResponsable, Request $request)
    {
        //$id= $session->get("id");
        //find groupe

        $id=$request->query->get('id');
        //rechercher le responsable dont l'id est celui en parametre
        $responsable = $repoResponsable->findOneByID($id);
        $responsable->setStatut(0);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($responsable);
        $manager->flush();


        return new Response("succes",200);

    }
    #[Route('/GetRespoUnique', name: 'GetRespoUnique')]
    public function GetRespoUnique(ResponsableRepository $repo, ExercerFonctionRepository $repoExercer, Request $request, SerializerInterface $serializer, AnneePastoraleRepository $repoAnnee){
        $id = $request->query->get("value");
        $qClass = new QueryClass($this->em);
    //     $ResponsableUnique = $repo->findOneByID($id);
    //     $activeYear = $repoAnnee->findActiveYear();
    //     $fonction = $repoExercer->findFonctionChef($id,$activeYear)[0]->getFonction();
    //     $ResponsableUnique->setFonctionLibelle($fonction->getLibelle());
    //     $ResponsableUnique->setFonctionId($fonction->getId());
    //    $date=$ResponsableUnique->getDob();
    //    $ResponsableUnique->setDateNaiss($date->format('Y-m-d'));
        $ResponsableUnique = $qClass->GetResponsableUnique($id);
       // var_dump($ResponsableUnique);
        $result = $serializer->serialize($ResponsableUnique,'json',   ['groups' => 'show_chef']);
        return new Response($result,200);
    }


      #[Route('/ModifierResponsable', name: 'ModifierResponsable')]
      public function UpdateResponsable(ResponsableRepository $repo, ExercerFonctionRepository $repoExercer, Request $request, SerializerInterface $serializer, AnneePastoraleRepository $repoAnnee, FONCTIONRepository $repofonction, FormationRepository $repoformation){

          try {
            $qClass = new QueryClass($this->em);
               
               $value = $request->request->get('value');
             //var_dump($value);
               $id = $value['id'];
              //dump($id);
             $ResponsableToUpdate = $repo->findOneBy(["id"=>$id]);
 
               $activeYear = $repoAnnee->findActiveYear();
               //dump($activeYear);



$fonctiontoupdate = $repofonction->findOneBy(["id"=>$value['fonction']]);
$fonction=$qClass->GetExercerfonction($ResponsableToUpdate->getId());


//get exercer fonction
$exofonction = $repoExercer->findOneBy(["id"=>$fonction]);

$exofonction->setFonction($fonctiontoupdate);

//get formation
$formationToUpdate = $ResponsableToUpdate->getResponsableFormations();
//formation selectionnée
$selectedFormation = $repoformation->findOneBy(["id"=> $value["formation"]]);
$formationToUpdate[0]->setFormationId($selectedFormation);





         // $formation = $repoformation->findOneBy(["id"=>$value["formation"]]);
      
            //  $nom = $ResponsableUnique->getNom() == $ResponsableToUpdate->getNom() ? $ResponsableUnique->getNom() : $ResponsableToUpdate->getNom();
              $nom = $ResponsableToUpdate->getNom() == $value["nom"] ? $ResponsableToUpdate->getNom() :  $value["nom"] ;
              $prenoms = $ResponsableToUpdate->getPrenoms() == $value["prenoms"] ? $ResponsableToUpdate->getPrenoms() :  $value["prenoms"] ;
              $occupation = $ResponsableToUpdate->getOccupation() == $value["occupation"] ? $ResponsableToUpdate->getOccupation() :  $value["occupation"] ;
              $habitation = $ResponsableToUpdate->getHabitation() == $value["habitation"] ? $ResponsableToUpdate->getHabitation() :  $value["habitation"] ;
              $telephone = $ResponsableToUpdate->getTelephone() == $value["telephone"] ? $ResponsableToUpdate->getTelephone() :  $value["telephone"] ;
              $telephone = $ResponsableToUpdate->getTelephone() == $value["telephone"] ? $ResponsableToUpdate->getTelephone() :  $value["telephone"] ;
         
            $formation = $repoformation->findOneBy(["id"=>$value["formation"]]);


              $ResponsableToUpdate->setNom($nom)
                                ->setPrenoms($prenoms)
                                ->setHabitation($habitation)
                                ->setOccupation($occupation)
                              //  ->addExercerFonction()
//                 // ->setDob($dob)
                            
                                ->setTelephone($telephone) 
                                //->addFormation($formation)
                                ;
             
               $manager = $this->getDoctrine()->getManager();
              $manager->persist($ResponsableToUpdate);
             $manager->persist($exofonction);
             $manager->persist($formationToUpdate[0]);
               $manager->flush();

               return new JsonResponse(["ok"=>true, "data"=>"Opération effectuée avec succès"]);
           }catch (\Exception $e){
            return new JsonResponse(["ok"=>false, "data"=>$e->getMessage()]);
          }

    }





   













































































    #[Route('/AjouterRespocg', name: 'AjouterRespocg')]
    public function AjouterRespocg(): Response
    {
        return $this->render('responsable/AddResponsableGroupe.html.twig', [
            'controller_name' => 'ResponsableController',
        ]);
    }

    #[Route('/ListeRespoCg', name: 'ListeRespoCg')]
    public function ListeRespoCg(): Response
    {
        return $this->render('responsable/indexrespoGroupe.html.twig', [
            'controller_name' => 'ResponsableController',
        ]);
    }





}
