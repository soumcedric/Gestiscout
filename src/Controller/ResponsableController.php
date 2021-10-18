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
        $Idgroupe = $session->get('groupeid');
        $ActiveYear = $this->AnneeLayer->findActiveYear();
        $qCls = new QueryClass($this->em);
        $ListResponsable =$qCls->GetListResponsableActif($Idgroupe->getId(),$ActiveYear[0]->getId());
        foreach ($ListResponsable as $respo)
        {
            $dateOfBirth = $respo->getDob();
            $respo->setDateNaiss($dateOfBirth->format('d-m-Y'));
        }




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
    public function AddResponsable(GenreRepository $genrerepo,SessionInterface $session,Request $value,ResponsableRepository $repoRespo, FONCTIONRepository $repoFonction, AnneePastoraleRepository $repoAnnee,GroupeRepository  $groupeRepo)
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
                    ->setGroupe($connectedGroupe[0]);

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
                    ->setGroupe($chosenGroup);

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
            //var_dump($e);
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
        $ResponsableUnique = $repo->findOneByID($id);
        $activeYear = $repoAnnee->findActiveYear();
        $fonction = $repoExercer->findFonctionChef($id,$activeYear)[0]->getFonction();
        $ResponsableUnique->setFonctionLibelle($fonction->getLibelle());
        $ResponsableUnique->setFonctionId($fonction->getId());
       $date=$ResponsableUnique->getDob();
       $ResponsableUnique->setDateNaiss($date->format('d/m/Y'));

        $result = $serializer->serialize($ResponsableUnique,'json',   ['groups' => 'show_chef']);
        return new Response($result,200);
    }


      #[Route('/ModifRespo', name: 'ModifRespo')]
      public function UpdateResponsable(ResponsableRepository $repo, ExercerFonctionRepository $repoExercer, Request $request, SerializerInterface $serializer, AnneePastoraleRepository $repoAnnee){

          try {

              $value = $request->request->get('value');
              $id = $value['id'];
              $ResponsableUnique = $repo->findOneByID($id);
              $activeYear = $repoAnnee->findActiveYear();
              $fonction = $repoExercer->findFonctionChef($id,$activeYear)[0]->getFonction();
              $ResponsableUnique->setFonctionLibelle($fonction->getLibelle());
              $ResponsableUnique->setFonctionId($fonction->getId());


              $ResponsableToUpdate = new Responsable();
              $ResponsableToUpdate->setNom($value['nom'])
                  // ->setNom($value['nom'])
                  ->setPrenoms($value['prenoms'])
                  //  ->setDob($value['dob'])
                  ->setHabitation($value['habitation'])
                  ->setOccupation($value['occupation'])
                  ->setTelephone($value["telephone"])
              ;


              $nom = $ResponsableUnique->getNom() == $ResponsableToUpdate->getNom() ? $ResponsableUnique->getNom() : $ResponsableToUpdate->getNom();
              $habitation = $ResponsableUnique->getPrenoms() == $ResponsableToUpdate->getPrenoms() ? $ResponsableUnique->getPrenoms() : $ResponsableToUpdate->getPrenoms();
              $occupation = $ResponsableUnique->getOccupation() == $ResponsableToUpdate->getOccupation() ? $ResponsableUnique->getOccupation() : $ResponsableToUpdate->getOccupation();
              $dob = $ResponsableUnique->getDob() == $ResponsableToUpdate->getDob() ? $ResponsableUnique->getDob() : $ResponsableToUpdate->getDob();
              $phone = $ResponsableUnique->getTelephone() == $ResponsableToUpdate->getTelephone() ? $ResponsableUnique->getTelephone() : $ResponsableToUpdate->getTelephone();
              $prenoms = $ResponsableUnique->getPrenoms() == $ResponsableToUpdate->getPrenoms() ? $ResponsableUnique->getPrenoms() : $ResponsableToUpdate->getPrenoms();



              $ResponsableUnique->setNom("")
                                ->setNom($nom)
                                ->setHabitation("")
                                ->setHabitation($habitation)
                                ->setOccupation("")
                                ->setOccupation($occupation)
//                 // ->setDob($dob)
                                ->setTelephone("")
                                ->setTelephone($phone)
                               ->setPrenoms("")
                              ->setPrenoms($prenoms)
              ;

              $manager = $this->getDoctrine()->getManager();
              $manager->persist($ResponsableUnique);
              $manager->flush();
          }catch (\Exception $e){

          }



        return new Response("success",200);
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
