<?php

namespace App\Controller;

use App\Entity\INSCRIPTION;
use App\Entity\JEUNE;
use App\Repository\AnneePastoraleRepository;
use App\Repository\GenreRepository;
use App\Repository\GroupeRepository;
use Cassandra\Date;
use Doctrine\Persistence\ObjectManager;
use http\Message;
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
use App\Classes\QueryClass;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Mime\Message as MimeMessage;

class JeuneController extends AbstractController
{

    private $brancheLayer;
    private $GenreLayer;
    private $repoGroupe;
    private $repoYear;
    private $EntityManager;
    private $anneeLayer;
    public function __construct(BrancheRepository $branche, GenreRepository $genre, GroupeRepository $groupe, AnneePastoraleRepository $repoyear,EntityManagerInterface  $Emanager, AnneePastoraleRepository $annee)
        {
            $this->brancheLayer = $branche;
            $this->GenreLayer = $genre;
            $this->repoGroupe = $groupe;
            $this->repoYear = $repoyear;
            $this->EntityManager=$Emanager;
            $this->anneeLayer = $annee;
        }


    #[Route('/jeune', name: 'jeune')]
    public function index(): Response
    {
        $this->addFlash('success', 'Event created!');
        return $this->render('jeune/index.html.twig', [
            'controller_name' => 'JeuneController',
        ]);
    }


    #[Route('/test', name: 'test')]
    public function test(): Response
    {
        $this->addFlash('success', 'Event created!');
        return $this->redirectToRoute('about');
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {

        return $this->render('jeune/about.html.twig', [
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



    #[Route('/success', name: 'success')]
    public function success()
    {

        return $this->render('jeune/success.html.twig', [
            'controller_name' => 'JeuneController',
        ]);
    }



    #[Route('/error', name: 'error')]
    public function error()
    {

        return $this->render('jeune/error.html.twig', [
            'controller_name' => 'JeuneController',
        ]);
    }


    #[Route('/ListeJeune', name: 'ListeJeune')]
    public function ListeJeune(SessionInterface $session, JEUNERepository $jeuneRepo, NormalizerInterface $normalizer,SerializerInterface $serializer)
    {
        try
        {
            $qClass = new QueryClass($this->EntityManager);
            $anneeActive = $this->anneeLayer->findActiveYear();
            $groupe= $session->get('groupeid');
            $anneeId=$anneeActive[0]->getId();
            $id=$groupe->getId();
            $listedesjeunes = $qClass->GetJeunesActifByGroupe($id);
            dump($id);
            $result = $serializer->serialize($listedesjeunes,'json',['groups'=>'read']);
            return new JsonResponse(["ok"=>true, "data"=>$result]);
        }
        catch(\Exception $e)
        {

        }        

       
    }


    #[Route('/ListeJeuneNonCotise', name: 'ListeJeuneNonCotise')]
    public function ListeJeuneNonCotise(SessionInterface $session, JEUNERepository $jeuneRepo, NormalizerInterface $normalizer,SerializerInterface $serializer)
    {

        $groupeId = $session->get('groupeid');
        $id = $groupeId->getId();
        $listedesjeunes = $jeuneRepo->GetJeuneActif($id);
        foreach ($listedesjeunes as $jeune) {
            $dateOfBirth = $jeune->getDob();
            $jeune->setDateNaiss($dateOfBirth->format('d-m-Y'));
        }
        dump($listedesjeunes);
        $result = $serializer->serialize($listedesjeunes, 'json', ['groups' => 'read']);

        return new Response($result, 200);
       
    }


    #[Route('/AddJeune', name: 'AddJeune')]
    public function AddJeune(SessionInterface $session): Response
    {
        $groupeId= $session->get('groupeid');
        $id=$groupeId->getId();
        $this->addFlash('success', 'Event created!');
          return $this->render('jeune/AddJeune.html.twig', [
            'controller_name' => 'JeuneController',
            'groupeid' => $id
      ]);

    }

    #[Route('/AddJeuneFunction', name: 'AddJeuneFunction')]
    function AddJeuneFunction(JEUNERepository $repojeune, GenreRepository $genreRepo, SessionInterface $session, Request $request, AnneePastoraleRepository $repoAnnee, BrancheRepository $repobranche, GroupeRepository $repoGropue)
    {
        try {
            $qClass = new Classes\QueryClass($this->EntityManager);

            // compute next id (consider using auto-increment in DB instead)
            $lastid = $repojeune->findBy([], ['id' => 'DESC'], 1, 0);
            $id = ($lastid === null || count($lastid) === 0) ? 1 : ($lastid[0]->getId() + 1);

            $groupeId = $session->get('groupeid');
            $connectedGroupe = $repoGropue->findGroupeById($groupeId->getId());
            $ActiveYear = $repoAnnee->findActiveYear();

            // get and validate input
            $nom = trim((string)$request->request->get('nom', ''));
            $prenoms = trim((string)$request->request->get('prenoms', ''));
            $dobRaw = $request->request->get('dob');
            $genreId = $request->request->get('genre');

            if ($nom === '' || $prenoms === '' || empty($dobRaw) || empty($genreId)) {
                return new JsonResponse(['ok' => false, 'message' => 'Missing required fields'], 400);
            }

            try {
                $date = new \DateTime($dobRaw);
            } catch (\Exception $ex) {
                return new JsonResponse(['ok' => false, 'message' => 'Invalid date format'], 400);
            }
            // Reject DOB in the future
            $today = new \DateTime('today');
            if ($date > $today) {
                return new JsonResponse(['ok' => false, 'message' => 'Date of birth cannot be in the future'], 400);
            }

            $genre = $genreRepo->findOneBy(['id' => $genreId]);
            if (!$genre) {
                return new JsonResponse(['ok' => false, 'message' => 'Genre not found'], 404);
            }

            $jeune = new JEUNE();
            $jeune->setNom($nom)
                ->setId($id)
                ->setPrenoms($prenoms)
                ->setDob($date)
                ->setLieuHabitation((string)$request->request->get('habitation', ''))
                ->setOccupation((string)$request->request->get('occupation', ''))
                ->setNomPere((string)$request->request->get('NomPere', ''))
                ->setNumMere((string)$request->request->get('NumMere', ''))
                ->setNumPere((string)$request->request->get('NumPere', ''))
                ->setStatut(1)
                ->setDateCreation(new \DateTime())
                ->setUserCreation('Admin')
                ->setTelephone((string)$request->request->get('phone', ''))
                ->setNomMere((string)$request->request->get('NomMere', ''))
                ->setGenre($genre)
                ->setGroupe($connectedGroupe[0]);

            $branche = $repobranche->findById($request->request->get('branche'));
            if ($branche && isset($branche[0])) {
                $jeune->setBranche($branche[0]);
            }

            $inscription = new INSCRIPTION();
            $inscription->setDateInscription(new \DateTime('now'))
                ->setJeunes($jeune)
                ->setAnnee($ActiveYear[0]);
            $jeune->addInscription($inscription);

            $this->EntityManager->persist($jeune);
            $this->EntityManager->flush();

            return new JsonResponse(['ok' => true, 'message' => 'Jeune ajouté avec succès'], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['ok' => false, 'message' => $e->getMessage()], 500);
        }
    }

    #[Route('/DeleteJeune', name: 'DeleteJeune')]
    public function DeleteJeune(Request $request, JEUNERepository $repo): Response
    {

        try {
            $Id = $request->query->get('id');
            $JeuneUnique = $repo->findOneById($Id);
            $JeuneUnique->setStatut(0);
            $this->EntityManager->persist($JeuneUnique);
            $this->EntityManager->flush();
            return new Response("success",200);
        }catch (\Exception $e){
            return new Response("fail",200);
        }



    }


    #[Route('/GetJeuneUnique', name: 'GetJeuneUnique')]
    public function GetJeuneUnique(Request $request, JEUNERepository $repo, SerializerInterface $serialize): JsonResponse
    {
        try {
            $id = $request->query->getInt('id');
            if ($id <= 0) {
                return new JsonResponse(['ok' => false, 'message' => 'Missing or invalid id'], 400);
            }

            $jeune = $this->JeuneUnique($id, $repo);
            if (!$jeune) {
                return new JsonResponse(['ok' => false, 'message' => 'Jeune not found'], 404);
            }

            // attach safe branche id if any
            $branche = $jeune->getBranche();
            $jeune->setBrancheId($branche ? $branche->getId() : null);

            // normalize date of birth if present
            $dob = $jeune->getDob();
            if ($dob instanceof \DateTimeInterface) {
                $jeune->setDateNaiss($dob->format('Y-m-d'));
            }

            $result = $serialize->serialize($jeune, 'json', ['groups' => 'read']);
            $data = json_decode($result, true);
            return new JsonResponse(['ok' => true, 'data' => $data], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['ok' => false, 'message' => $e->getMessage()], 500);
        }
    }
    

    function JeuneUnique(int $id, JEUNERepository $jeune) : ?JEUNE
    {
        return $jeune->findOneById($id);
    }

    #[Route('/ModifierJeune', name: 'ModifierJeune')]
    function ModifierJeune(Request $request, BrancheRepository $repobranche, JEUNERepository $jeunerepo)
    {
        // Support payload in 'value' (array/json) or direct form fields
        $payload = $request->request->get('value');
        if (is_string($payload)) {
            $decoded = json_decode($payload, true);
            $payload = $decoded ?: null;
        }
        $input = is_array($payload) ? $payload : $request->request->all();

        $id = $input['id'] ?? null;
        if (empty($id)) {
            return new JsonResponse(['ok' => false, 'message' => 'Missing id'], 400);
        }

        $jeuneUnique = $this->JeuneUnique((int)$id, $jeunerepo);
        if (!$jeuneUnique) {
            return new JsonResponse(['ok' => false, 'message' => 'Jeune not found'], 404);
        }

        // Helper to get field from input with fallback to null
        $get = function ($key) use ($input) {
            return array_key_exists($key, $input) ? $input[$key] : null;
        };

        $fieldsToUpdate = [
            'nom' => 'setNom',
            'prenoms' => 'setPrenoms',
            'telephone' => 'setTelephone',
            'habitation' => 'setLieuHabitation',
            'occupation' => 'setOccupation',
            'nomPere' => 'setNomPere',
            'numPere' => 'setNumPere',
            'numMere' => 'setNumMere',
            'NomMere' => 'setNomMere'
        ];

        foreach ($fieldsToUpdate as $key => $setter) {
            $val = $get($key);
            if ($val !== null && $val !== '') {
                $jeuneUnique->{$setter}((string)$val);
            }
        }

        // branche
        $brancheId = $get('branche');
        if (!empty($brancheId)) {
            $branche = $repobranche->findOneBy(['id' => $brancheId]);
            if ($branche) {
                $jeuneUnique->setBranche($branche);
            }
        }

        // update modification metadata
        $jeuneUnique->setDateModification(new \DateTime());
        $jeuneUnique->setUserModification('Admin');

        $this->EntityManager->persist($jeuneUnique);
        $this->EntityManager->flush();

        return new JsonResponse(['ok' => true, 'message' => 'Jeune modifié avec succès'], 200);
    }
    #[Route('/ImportData', name: 'ImportData')]
    function ImportData(Request $value, JEUNERepository $RepoJeune,SessionInterface $session, UserRepository $userRepo)
    {

        try
        {
           // dump($value);
            $data = $value->request->get("value");
            $rows = json_decode($data,true);
          
          
             $groupe= $session->get('groupeid');
             $userconnected = $userRepo->findOneBy(["id"=>$session->get("id")])->getUserIdentifier();
             
             $id=$groupe->getId();
             $connectedGroupe = $this->repoGroupe->findOneBy(["id"=>$id]);
             foreach($rows as $r)
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
    
                $newJeune = new JEUNE();
                 $newJeune->setId($id)
                          ->setNom($r["NOM"])
                          ->setPrenoms($r["PRENOMS"])
                          ->setDob(new \DateTime($r["DOB"]))
                          ->setLieuHabitation($r["HABITATION"])
                          ->setOccupation($r["OCCUPATION"])
                          ->setTelephone($r["TELEPHONE"])
                          ->setNomPere($r["PERE"])
                          ->setNumPere($r["NUMPERE"])
                          ->setNomMere($r["MERE"])
                          ->setNumMere($r["NUMMERE"])
                          ->setBranche($this->brancheLayer->findOneBy(["Libelle"=>strtolower($r["BRANCHE"])]))
                          ->setGenre($this->GenreLayer->findOneBy(["Libelle"=>strtolower($r["GENRE"])]))
                          ->setDateCreation(new \DateTime("now"))
                          ->setStatut(1)
                          ->setGroupe($connectedGroupe)
                          ->setUserCreation($userconnected);
                          $inscription = new INSCRIPTION();
                              $ActiveYear = $this->repoYear->findActiveYear();
                              $inscription->setDateInscription(new \DateTime("now"))
                                  ->setJeunes($newJeune)
                                  ->setAnnee($ActiveYear[0]);
                              $newJeune->addInscription($inscription);
                               $this->EntityManager->persist($newJeune);
                                  $this->EntityManager->flush();
             
             }
         

            return new JsonResponse(["ok"=>true, "message"=>"Opération effectuée avec succès"]);
        }
        catch(\Exception $e)
        {
            $this->addFlash('success', 'Event created!');
            return new JsonResponse(["ok"=>false, "message"=>$e->getMessage()]);
    
        }

    }
    #[Route('/ImportJeune', name: 'ImportJeune')]
    function ImportationJeune()
    {

        return $this->render('jeune/ImportJeune.html.twig', [
            'controller_name' => 'JeuneController',
        ]);
    }


    #[Route('/Import', name: 'Import')]
    function Import(Request $request, SessionInterface $session, 
                        GroupeRepository $groupeRepo, SerializerInterface $serializer)
    {
        $groupe = $session->get('groupeid');
        $groupeName = $groupeRepo->findOneBy(["id" => $groupe->getId()])->getNom();

        // target directory inside project public/uploads
        $targetfile = $this->getParameter('kernel.project_dir').'/public/uploads/importjeune';

        $fs = new Filesystem();
        try {
            if (!$fs->exists($targetfile)) {
                $fs->mkdir($targetfile, 0775);
            }
        } catch (IOExceptionInterface $e) {
            return new JsonResponse(["ok" => false, "message" => 'Unable to create target directory: ' . $e->getMessage()]);
        }

        $uploadedFile = $request->files->get('file');
        if ($uploadedFile && $uploadedFile instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
            $originalName = $uploadedFile->getClientOriginalName();
            $extension = $uploadedFile->guessExtension() ?: pathinfo($originalName, PATHINFO_EXTENSION);
            $filename = pathinfo($originalName, PATHINFO_FILENAME);
            $newFileName = str_replace(' ', '_', $filename . '_' . $groupeName . '_' . uniqid() . '.' . $extension);
            try {
                $uploadedFile->move($targetfile, $newFileName);
            } catch (\Exception $e) {
                return new JsonResponse(["ok" => false, "message" => 'Upload failed: ' . $e->getMessage()]);
            }
        } else {
            // legacy fallback to PHP globals
            if (!isset($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
                return new JsonResponse(["ok" => false, "message" => 'No uploaded file found']);
            }
            $originalName = $_FILES['file']['name'];
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $filename = pathinfo($originalName, PATHINFO_FILENAME);
            $newFileName = str_replace(' ', '_', $filename . '_' . $groupeName . '_' . uniqid() . '.' . $extension);
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetfile . '/' . $newFileName)) {
                return new JsonResponse(["ok" => false, "message" => 'Could not move uploaded file']);
            }
        }

        $lines = array();
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($targetfile.'//'.$newFileName);
        $highetsrow = $spreadsheet->getActiveSheet()->getHighestDataRow();
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestDataColumn();
        $numberOfColumn = $this->MapAlphabeticLetter($highestColumn);
        $activeSheet = $spreadsheet->getActiveSheet();
        for ($t=2;$t<=$highetsrow;$t++)
        {
           // $jeune = new JEUNE();
            if(is_null($spreadsheet->getActiveSheet()->getCellByColumnAndRow(3,$t)->getValue()))
            {

            }
            else
            {
                $line = array(
                            "NOM"=>$activeSheet->getCellByColumnAndRow(1,$t)->getValue(),
                            "PRENOMS"=>$activeSheet->getCellByColumnAndRow(2,$t)->getValue(),
                            "DOB"=>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($activeSheet->getCellByColumnAndRow(3,$t)->getValue())->format('d/m/Y'),
                            "TELEPHONE"=>$activeSheet->getCellByColumnAndRow(7,$t)->getValue(),
                            "OCCUPATION"=>$activeSheet->getCellByColumnAndRow(6,$t)->getValue(),
                            "HABITATION"=>$activeSheet->getCellByColumnAndRow(5,$t)->getValue(),
                            "PERE"=>$activeSheet->getCellByColumnAndRow(8,$t)->getValue(),
                            "NUMPERE"=>$activeSheet->getCellByColumnAndRow(9,$t)->getValue(),
                            "MERE"=>$activeSheet->getCellByColumnAndRow(10,$t)->getValue(),
                            "NUMMERE"=>$activeSheet->getCellByColumnAndRow(11,$t)->getValue(),
                            "BRANCHE"=>$activeSheet->getCellByColumnAndRow(12,$t)->getValue(),
                            "GENRE"=>$activeSheet->getCellByColumnAndRow(4,$t)->getValue()
                );
                array_push($lines,$line);
               
            }
        }


      //  dump($lines);



        //$flashy->primaryDark('Event Created','hello');
       // dump($request);
       $liste = $serializer->serialize($lines,'json');
        return new JsonResponse($liste);
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
