<?php

namespace App\Controller;

use App\Entity\INSCRIPTION;
use App\Entity\JEUNE;
use App\Repository\AnneePastoraleRepository;
use App\Repository\GenreRepository;
use App\Repository\GroupeRepository;
use Cassandra\Date;
use Doctrine\Persistence\ObjectManager;
use MongoDB\Driver\Session;
use Symfony\Component\HttpFoundation\Request;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JEUNERepository;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BrancheRepository;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use ZipStream\File;
use App\Classes;


class JeuneController extends AbstractController
{

    private $brancheLayer;
    private $GenreLayer;
    private $repoGroupe;
    private $repoYear;
    private $EntityManager;
    public function __construct(BrancheRepository $branche, GenreRepository $genre, GroupeRepository $groupe, AnneePastoraleRepository $repoyear,EntityManagerInterface  $Emanager)
        {
            $this->brancheLayer = $branche;
            $this->GenreLayer = $genre;
            $this->repoGroupe = $groupe;
            $this->repoYear = $repoyear;
            $this->EntityManager=$Emanager;
        }


    #[Route('/jeune', name: 'jeune')]
    public function index(): Response
    {
        return $this->render('jeune/index.html.twig', [
            'controller_name' => 'JeuneController',
        ]);
    }



    #[Route('/ListeJeunes', name: 'ListeJeunes')]
    public function ListeJeunes()
    {

        return $this->render('jeune/ListeJeunes.html.twig', [
            'controller_name' => 'JeuneController',
        ]);
    }



  #[Route('/ListeJeune', name: 'ListeJeune')]
    public function ListeJeune(SessionInterface $session, JEUNERepository $jeuneRepo, NormalizerInterface $normalizer,SerializerInterface $serializer)
    {

        $groupeId= $session->get('groupeid');
        $id=$groupeId->getId();
        $listedesjeunes = $jeuneRepo->GetJeuneActif($id);
        foreach ($listedesjeunes as $jeune)
        {
            $dateOfBirth = $jeune->getDob();
            $jeune->setDateNaiss($dateOfBirth->format('d-m-Y'));
        }
$result = $serializer->serialize($listedesjeunes,'json',['groups'=>'read']);

        return new Response($result,200);

    }












    #[Route('/ListeJeuneNonCotise', name: 'ListeJeuneNonCotise')]
    public function ListeJeuneNonCotise(SessionInterface $session, JEUNERepository $jeuneRepo, NormalizerInterface $normalizer,SerializerInterface $serializer)
    {

        $groupeId= $session->get('groupeid');
        $id=$groupeId->getId();
        $listedesjeunes = $jeuneRepo->GetJeuneActif($id);
        foreach ($listedesjeunes as $jeune)
        {
            $dateOfBirth = $jeune->getDob();
            $jeune->setDateNaiss($dateOfBirth->format('d-m-Y'));
        }
        $result = $serializer->serialize($listedesjeunes,'json',['groups'=>'read']);

        return new Response($result,200);
        // return new JsonResponse('no result found',200);
//          return $this->render('jeune/ListeJeunes.html.twig',
//            array('liste'=>$listedesjeunes)
//        );
        // return $this->json(true);

        // return $listedesjeunes;
    }











    #[Route('/AddJeune', name: 'AddJeune')]
    public function AddJeune(): Response
    {

          return $this->render('jeune/AddJeune.html.twig', [
            'controller_name' => 'JeuneController',
      ]);







        return $this->render('jeune/ListeJeune.html.twig', [
            'controller_name' => 'JeuneController',
        ]);
    }

    #[Route('/AddJeuneFunction', name: 'AddJeuneFunction')]
    function AddJeuneFunction(JEUNERepository $repojeune, GenreRepository $genreRepo,SessionInterface $session,Request  $value, AnneePastoraleRepository  $repoAnnee, BrancheRepository  $repobranche,GroupeRepository $repoGropue){
        try {


            $qClass = new Classes\QueryClass($this->EntityManager);
            $lastid = $repojeune->findBy(array(),array('id'=>'DESC'),1,0);

            $id=0;
            if($lastid == null)
            {
                $id = 1;
            }
            else
            {
                $id =  $lastid[0]->getId()+1;
            }

        $groupeId= $session->get('groupeid');

        $connectedGroupe = $repoGropue->findGroupeById($groupeId->getId());
        $ActiveYear = $repoAnnee->findActiveYear();
        $jeune = new JEUNE();
        $young = $value->request->get('value');
        $time  = strtotime($young["dob"]);
        $date= new \DateTime($young["dob"]);
        $genre =  $genreRepo->findOneBy(["id"=>$young["genre"]]);

        $jeune->setNom($young["nom"])
                ->setId($id)
                ->setPrenoms($young["prenoms"])
                ->setDob($date)
                ->setLieuHabitation($young["habitation"])
                ->setOccupation($young["occupation"])
                ->setNomPere(($young["NomPere"]))
                ->setNumMere($young["NumMere"])
                ->setNumPere(($young["NumPere"]))
                ->setStatut(1)
                ->setDateCreation(new \DateTime())
                ->setUserCreation("Admin")
                ->setTelephone($young["phone"])
                ->setNomMere($young["NomMere"])
                ->setGenre($genre)
                ->setGroupe($connectedGroupe[0]);


        $branche = $repobranche->findById($young["branche"]);

        $datetime = date('Y/m/d H:i:s');
        $inscription = new INSCRIPTION();
        $inscription  ->setDateInscription(new \DateTime("now"))
                      ->setJeunes($jeune)
                      ->setAnnee($ActiveYear[0]);
        $jeune->addInscription($inscription);
       $jeune->setBranche($branche[0]);
        //echo $jeune;
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($jeune);
        $manager->flush();

       return new Response('true',200);
        }catch (\Exception $e){
           // echo $e->getMessage();
            return $this->json($e->getMessage());
        }
    }

    #[Route('/DeleteJeune', name: 'DeleteJeune')]
    public function DeleteJeune(Request $request, JEUNERepository $repo): Response
    {

        try {
            $Id = $request->query->get('id');
            $JeuneUnique = $repo->findOneById($Id);
            $JeuneUnique->setStatut(0);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($JeuneUnique);
            $manager->flush();
            return new Response("success",200);
        }catch (\Exception $e){
            return new Response("fail",200);
        }



    }


    #[Route('/GetJeuneUnique', name: 'GetJeuneUnique')]
    public function GetJeuneUnique(Request $request, JEUNERepository $repo, SerializerInterface $serialize): Response
    {

        try {
            $Id = $request->query->get('id');
            $JeuneUnique = $this->JeuneUnique($Id,$repo);
            $brancheid = $JeuneUnique->getBranche()->getId();
            $JeuneUnique->setBrancheId($brancheid);
            $JeuneUnique->setDateNaiss($JeuneUnique->getDob()->format('Y-m-d'));
            $result = $serialize->serialize($JeuneUnique,'json',['groups'=>'read']);
            return new Response($result,200);
        }catch (\Exception $e){
            return new Response("fail",200);
        }



    }

    function JeuneUnique(int $id, JEUNERepository $jeune) : JEUNE
    {
        return $jeune->findOneById($id);
    }

    #[Route('/ModifierJeune', name: 'ModifierJeune')]
    function ModifierJeune(Request  $value,BrancheRepository  $repobranche, JEUNERepository $jeunerepo){


        $jeune = new JEUNE();
        $young = $value->request->get('value');
        //$time  = strtotime($young["dob"]);
        //$date = new \DateTime($young["dob"]);
        $jeune->setNom($young["nom"])
            ->setPrenoms($young["prenoms"])
          //  ->setDob($date)
            ->setLieuHabitation($young["habitation"])
            ->setOccupation($young["occupation"])
            ->setNomPere(($young["NomPere"]))
            ->setNumMere($young["NumMere"])
            ->setNumPere(($young["NumPere"]))
            ->setStatut(1)
            ->setDateCreation(new \DateTime())
            ->setUserCreation("Admin")
            ->setTelephone($young["phone"])
            ->setNomMere($young["NomMere"]);

        //get branche
        $branche = $repobranche->findOneBy(["id"=>$young["branche"]]);
        $jeune->setBranche($branche);



        $jeuneUnique = $this->JeuneUnique($young["id"],$jeunerepo);

        $nom = $jeuneUnique->getNom()==$jeune->getNom() ? $jeuneUnique->getNom() : $jeune->getNom();
        $prenoms = $jeuneUnique->getPrenoms()==$jeune->getPrenoms() ? $jeuneUnique->getPrenoms() : $jeune->getPrenoms();
        $telephone = $jeuneUnique->getTelephone()==$jeune->getTelephone() ? $jeuneUnique->getTelephone() : $jeune->getTelephone();
        $dob = $jeuneUnique->getDob()==$jeune->getDob() ? $jeuneUnique->getDob() : $jeune->getDob();
        $nomPere = $jeuneUnique->getNomPere()==$jeune->getNomPere() ? $jeuneUnique->getNomPere() : $jeune->getNomPere();
        $numPere = $jeuneUnique->getNumPere()==$jeune->getNumPere() ? $jeuneUnique->getNumPere() : $jeune->getNumPere();
        $numMere = $jeuneUnique->getNumMere()==$jeune->getNumMere() ? $jeuneUnique->getNumMere() : $jeune->getNumMere();
        $nomMere = $jeuneUnique->getNomMere()==$jeune->getNomMere() ? $jeuneUnique->getNomMere() : $jeune->getNomMere();
        $branche = $jeuneUnique->getBranche()==$jeune->getBranche() ? $jeuneUnique->getBranche() : $jeune->getBranche();
        $occupation = $jeuneUnique->getOccupation()==$jeune->getOccupation() ? $jeuneUnique->getOccupation() : $jeune->getOccupation();
        $habitation = $jeuneUnique->getLieuHabitation()==$jeune->getLieuHabitation() ? $jeuneUnique->getLieuHabitation() : $jeune->getLieuHabitation();

        $jeuneUnique->setNom($nom)
                    ->setPrenoms($prenoms)
                    ->setTelephone($telephone)
                    ->setLieuHabitation($telephone)
                    ->setOccupation($occupation)
                    ->setNomPere($nomPere)
                    ->setNumPere($numPere)
                    ->setNomMere($nomMere)
                    ->setNumPere($numMere)
                    ->setDateModification(new \DateTime())
                    ->setUserModification("Admin")
                    ->setBranche($branche);


        $manager = $this->getDoctrine()->getManager();
        $manager->persist($jeuneUnique);
        $manager->flush();

        return new Response(true,200);
    }
    #[Route('/ImportData', name: 'ImportData')]
    function ImportData(Request $value, JEUNERepository $RepoJeune,SessionInterface $session)
    {





        $groupeId= $session->get('groupeid');
        $id=$groupeId->getId();
        $connectedGroupe = $this->repoGroupe->findGroupeById($id);
        $baseDir = realpath(__DIR__ . '/../../Upload');
        $fichier=$_FILES["fichier"]["name"];
        $real = realpath($_FILES["fichier"]["tmp_name"]);
        $extension = $_FILES["fichier"]["type"];
        $handle = fopen($_FILES["fichier"]["tmp_name"],'r');
        move_uploaded_file($_FILES["fichier"]["tmp_name"],$baseDir.'//'.$fichier);
        $newfile = $baseDir.'//'.$fichier;
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
        $spreadsheet = $reader->load($newfile);
        $highetsrow = $spreadsheet->getActiveSheet()->getHighestDataRow();
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestDataColumn();
        $numberOfColumn = $this->MapAlphabeticLetter($highestColumn);

        for ($t=2;$t<=$highetsrow;$t++)
        {

            $qClass = new Classes\QueryClass($this->EntityManager);
            $lastid = $RepoJeune->findBy(array(),array('id'=>'DESC'),1,0);

            $id=0;
            if($lastid == null)
            {
                $id = 1;
            }
            else
            {
                $id =  $lastid[0]->getId()+1;
            }










            //get date de naissance and convert it
            $datenaiss=$spreadsheet->getActiveSheet()->getCellByColumnAndRow(3,$t)->getValue();
            $Dob= new \DateTime($datenaiss);
            //get branche
            $brancheFromExcel = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(12,$t)->getValue();
            $genreFromExcel = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4,$t)->getValue();
            $branche = $this->brancheLayer->findOneBy(["Libelle"=>$brancheFromExcel]);

            $genre = $this->GenreLayer->findOneBy(["Libelle"=>$genreFromExcel]);
            $jeune = new JEUNE();
            $jeune->setNom($spreadsheet->getActiveSheet()->getCellByColumnAndRow(1,$t)->getValue())
                  ->setId($id)
                  ->setPrenoms($spreadsheet->getActiveSheet()->getCellByColumnAndRow(2,$t)->getValue())
                  ->setDob($Dob)
                  ->setGenre($genre)
                 ->setLieuHabitation($spreadsheet->getActiveSheet()->getCellByColumnAndRow(5,$t)->getValue())
                 ->setOccupation($spreadsheet->getActiveSheet()->getCellByColumnAndRow(6,$t)->getValue())
                 ->setTelephone($spreadsheet->getActiveSheet()->getCellByColumnAndRow(7,$t)->getValue())
                ->setNomPere($spreadsheet->getActiveSheet()->getCellByColumnAndRow(8,$t)->getValue())
                ->setNumPere($spreadsheet->getActiveSheet()->getCellByColumnAndRow(9,$t)->getValue())
                ->setNomMere($spreadsheet->getActiveSheet()->getCellByColumnAndRow(10,$t)->getValue())
                ->setNumMere($spreadsheet->getActiveSheet()->getCellByColumnAndRow(11,$t)->getValue())
               ->setBranche($branche)
                ->setDateCreation(new \DateTime())
                ->setStatut(1)
                ->setGroupe($connectedGroupe[0])
                ->setUserCreation("ADMIN");
          $inscription = new INSCRIPTION();
            $ActiveYear = $this->repoYear->findActiveYear();
              $inscription->setDateInscription(new \DateTime("now"))
                          ->setJeunes($jeune)
                          ->setAnnee($ActiveYear[0]);
            $jeune->addInscription($inscription);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($jeune);
            $manager->flush();


        }



        return null;
    }
    #[Route('/ImportJeune', name: 'ImportJeune')]
    function ImportationJeune()
    {
        return $this->render('jeune/ImportJeune.html.twig', [
            'controller_name' => 'JeuneController',
        ]);
    }



    function MapAlphabeticLetter($i): int
    {
            switch ($i)
            {
                case 'A':
                    return 1;
                    break;
                case 'B' :
                    return 2;
                    break;
                case 'C' :
                    return 3;
                    break;
                case 'D' :
                    return 4;
                    break;
                case 'E' :
                    return 5;
                    break;
                case 'F' :
                    return 6;
                    break;
                case 'G' :
                    return 7;
                    break;
                case 'H' :
                    return 8;
                    break;
                case 'I' :
                    return 9;
                    break;
                case 'J' :
                    return 10;
                    break;
                case 'K' :
                    return 11;
                    break;

                case 'L' :
                    return 12;
                    break;
                case 'M' :
                    return 13;
                    break;
                    return 0;
                case 'N' :
                    return 14;
                    break;
                default:
                    return 0;



            }
    }

}
