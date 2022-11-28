<?php

namespace App\Controller;

use App\Entity\Branche;
use App\Entity\JEUNE;
use App\Classes;

use App\Repository\GenreRepository;
use http\Client\Request;
use App\Entity\FONCTION;
use App\Entity\Groupe;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnneePastoraleRepository;
use App\Repository\GroupeRepository;
use App\Entity\AnneePastorale;
use App\Entity\CommissariatDistrict;
use App\Entity\Formation;
use App\Repository\BrancheRepository;
use App\Repository\CommissariatDistrictRepository;
use App\Repository\FormationRepository;
use App\Repository\TypeDocumentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Services\FileUploader;
use Symfony\Component\String\Slugger\SluggerInterface;

class ConfigurationController extends AbstractController
{
    private $EntityManager;

    public function __construct(EntityManagerInterface  $Emanager)
    {
        $this->EntityManager = $Emanager;
    }

    #[Route('/configuration', name: 'configuration')]
    public function index(): Response
    {
        return $this->render('configuration/index.html.twig', [
            'controller_name' => 'ConfigurationController',
        ]);
    }

    #[Route('/ListeAnnePastorale', name: 'ListeAnnePastorale')]
    public function ListeAnnePastorale(): Response
    {
        return $this->render('configuration/ListeAnneePastoral.html.twig', [
            'controller_name' => 'ConfigurationController',
        ]);
    }

    #[Route('/GetListeAnnee', name: 'GetListeAnnee')]
    public function GetListeAnnee(AnneePastoraleRepository $repo, SerializerInterface $serialiser)
    {
        try {
            // $liste = $repo->findOneBy(["bActif"=>true]);
            $liste = $repo->findAll();
            //dump($liste);
            $listeAnneePastorale =  $serialiser->serialize($liste, 'json', ["groups" => "readAnnee"]);

            return  new JsonResponse(["ok" => true, "data" => $listeAnneePastorale]);
        } catch (\Exception $e) {
            return new JsonResponse(['ok' => false, 'message' => $e->getMessage()]);
        }
    }


    #[Route('/AddAnnee', name: 'AddAnnee')]
    public function AddAnnee(\Symfony\Component\HttpFoundation\Request $value): Response
    {

        $NewYear = new AnneePastorale();
        $fromjson = $value->request->get('value');
        $date = $fromjson["Debut"];
        $code = $fromjson["Code"];
        $datedebut = new \DateTime($fromjson["Debut"]);
        $datefin = new \DateTime($fromjson["Fin"]);

        $currenttime = date('H:i:s \O\n d/m/Y');
        $NewYear->setCodeAnnee($fromjson["Code"])
            ->setDateDebut($datedebut)
            ->setDateFin($datefin)
            ->setBActif($fromjson["bActif"])
            ->setUserCreation("admin");
        $NewYear->setDateCreation(new \DateTime());



        $manager = $this->getDoctrine()->getManager();
        $manager->persist($NewYear);
        $manager->flush();
        return  new \Symfony\Component\HttpFoundation\Response(true, 200);
        //        $time  = strtotime($young["dob"]);
        //        $date = new \DateTime($young["dob"]);
    }


    #[Route('/ListeFonction', name: 'ListeFonction')]
    public function ListeFonction(): Response
    {
        return $this->render('configuration/ListeFonction.html.twig', [
            'controller_name' => 'ConfigurationController',
        ]);
    }

    #[Route('/AddFonction', name: 'AddFonction')]
    public function AddFonction(\App\Repository\FONCTIONRepository  $repo, \Symfony\Component\HttpFoundation\Request $value): Response
    {

        $newFonction = new FONCTION();

        $fromjson = $value->request->get('value');
        $newFonction->setCode($fromjson["Code"]);
        $newFonction->setLibelle($fromjson["Libelle"]);
        $newFonction->setRole($fromjson["Role"]);
        $newFonction->setDateCreation(new \DateTime());
        //  $newFonction->setUserCreation("Admin");



        $manager = $this->getDoctrine()->getManager();
        $manager->persist($newFonction);
        $manager->flush();

        return  new \Symfony\Component\HttpFoundation\Response(true, 200);
        //        return $this->render('configuration/ListeFonction.html.twig', [
        //            'controller_name' => 'ConfigurationController',
        //        ]);
    }


    #[Route('/GetListeFonction', name: 'GetListeFonction')]
    public function GetListeFonction(\App\Repository\FONCTIONRepository  $repo, SerializerInterface $serializer): Response
    {
        $listeFonction = $repo->findAll();

        $result = $serializer->serialize($listeFonction, 'json', ['groups' => 'fonction']);
        return  new \Symfony\Component\HttpFoundation\Response($result, 200);
    }

    #[Route('/GetListBranche', name: 'GetListBranche')]
    public function GetListBranche(\App\Repository\BrancheRepository  $repo, NormalizerInterface $normalizer, SerializerInterface $serializer): Response
    {
        $listeBranche = $repo->findAll();
        //        $listeNormalized =  $normalizer->normalize($listeBranche,null,["groups"=>"branche"]);//,null,['groups'=>'post:read']);
        //        $result = json_encode($listeNormalized);
        $result = $serializer->serialize($listeBranche, 'json', ['groups' => 'branche']);
        return  new \Symfony\Component\HttpFoundation\Response($result, 200);
    }

    #[Route('/ListeBranche', name: 'ListeBranche')]
    public function ListeBranche(): Response
    {
        return $this->render('configuration/ListeBranche.html.twig', [
            'controller_name' => 'ConfigurationController',
        ]);
    }


    #[Route('/AddBranche', name: 'AddBranche')]
    public function AddBranche(\App\Repository\BrancheRepository  $repo, \Symfony\Component\HttpFoundation\Request $value): Response
    {

        $newBranche = new Branche();

        $fromjson = $value->request->get('value');
        $newBranche->setLibelle($fromjson["Libelle"]);
        $newBranche->setTrancheAge($fromjson["Age"]);
        $newBranche->setDateCreation(new \DateTime());



        $manager = $this->getDoctrine()->getManager();
        $manager->persist($newBranche);
        $manager->flush();

        return  new \Symfony\Component\HttpFoundation\Response(true, 200);
        //        return $this->render('configuration/ListeFonction.html.twig', [
        //            'controller_name' => 'ConfigurationController',
        //        ]);
    }

    #[Route('/Groupe', name: 'Groupe')]
    public function Groupe(): Response
    {
        return $this->render('configuration/Groupe.html.twig', [
            'controller_name' => 'ConfigurationController',
        ]);
    }

    #[Route('/AddGroupe', name: 'AddGroupe')]
    public function AddGroupe(\Symfony\Component\HttpFoundation\Request $request, FileUploader $fileupload, CommissariatDistrictRepository $cdRepository,SluggerInterface $slugger): Response
    {
        try {
            
           // $values = $request->request->get('groupe'); 
    
            // $img = $values["img"];

            // $strindex = strpos($img, '.');
            // $extension = substr($img, $strindex);

            //$value->request->get("nom")
            $newGroupe = new Groupe();
            $newGroupe->setNom($request->get("nom"))
                ->setNickName($request->get("nickname"))
                ->setPhone1($request->get("phone1"))
                ->setPhone2($request->get("phone2"))
                ->setEmail($request->get("mail"))
                ->setSlogan("")
                ->setRegion($request->get("region"))
                ->setParoisse($request->get("paroisse"))
                ->setDateCreation(new \DateTime());
               // ->setExtension($extension)
              //  ->setFilebasetext($values["logo"])
               // ->setFilename($values["nom"] . trim(""));
              


             //get district
             $districtSelected = $cdRepository->findOneBy(["id" => $request->get("District")]);
             $newGroupe->setCommissariatDistrict($districtSelected);

            //file management
            $file = $request->files->get('image_path');

             $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
             $safeFilename = $slugger->slug($originalFilename);
             $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
             $file->move(
                $this->getParameter('brochures_directory'),
                $newFilename
              );


            $newGroupe->setFilename($newFilename);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newGroupe);
            $manager->flush();

            return new JsonResponse(['ok' => true, 'message' => "Opération effectuée avec succès"]);
          
        } catch (\Exception $e) {
            return new JsonResponse(['ok' => false, 'message' => $e->getMessage()]);
        }

        // return new Response();



    }

    #[Route('/GetAnneePastoraleUnique', name: 'GetAnneePastoraleUnique')]
    public function GetUniqueAnneePastorale(\Symfony\Component\HttpFoundation\Request $value, \App\Repository\AnneePastoraleRepository  $repo, NormalizerInterface $normalizer, SerializerInterface $serialiser): Response
    {
        $id = $value->get("value");
        $AneePastorale = $repo->findUniqueAnneePastorale($id);
        $annee =  $serialiser->serialize($AneePastorale, 'json', ["groups" => "readAnnee"]);
        return  new \Symfony\Component\HttpFoundation\Response($annee, 200);
    }




    #[Route('/GetListGroupe', name: 'GetListGroupe')]
    public function GetListGroupe(GroupeRepository $repo, NormalizerInterface $normalizer)
    {
        $liste = $repo->findAll();
        //dump($liste);
        $listeNormalized =  $normalizer->normalize($liste, 'json', ['groups' => 'groupe']); //,null,['groups'=>'post:read']);
        //$result = json_encode($listeNormalized);
        return new JsonResponse(['ok' => true, 'data' => $listeNormalized]);
    }


    #[Route('/GetListeGenre', name: 'GetListeGenre')]
    public function GetListeGenre(GenreRepository $repo, SerializerInterface $serializer)
    {
        $liste = $repo->findAll();

        $listeGenre =  $serializer->serialize($liste, 'json', ['groups' => 'genre']); //,null,['groups'=>'post:read']);
        // $result = json_encode($listeGenre);
        return  new \Symfony\Component\HttpFoundation\Response($listeGenre, 200);
    }


    #[Route('/UpdateAnneePastorale', name: 'UpdateAnneePastorale')]
    public function UpdateAnneePastorale(HttpFoundationRequest $request, AnneePastoraleRepository $repo, EntityManagerInterface $entitymanager)
    {
        try {


            // dump($request);
            $data = $request->request->get("value");
            $id = $data["id"];
            $boolvalue = false;
            if ($data["bActif"] == "true") {
                $boolvalue = true;
            }
            //get annee pastorale unique before modifying
            $anneePastoraleToUpdate = $repo->findOneBy(["id" => $id]);
            //dump($anneePastoraleToUpdate);

            $code = $anneePastoraleToUpdate->getCodeAnnee() == $data["Code"] ? $anneePastoraleToUpdate->getCodeAnnee() : $data["Code"];
            $datedebut = $anneePastoraleToUpdate->getDateDebut() == new \DateTime($data["Debut"]) ? $anneePastoraleToUpdate->getDateDebut() : new \DateTime($data["Debut"]);
            $datefin = $anneePastoraleToUpdate->getDateFin() == new \DateTime($data["Fin"]) ? $anneePastoraleToUpdate->getDateFin() : new \DateTime($data["Fin"]);
            $actif = $anneePastoraleToUpdate->getBActif() == $boolvalue ? $anneePastoraleToUpdate->getBActif() : $boolvalue;

            $anneePastoraleToUpdate->setCodeAnnee($code);
            $anneePastoraleToUpdate->setDateDebut($datedebut);
            $anneePastoraleToUpdate->setDateFin($datefin);
            $anneePastoraleToUpdate->setBActif($actif);
            $anneePastoraleToUpdate->setDateModification(new \DateTime());

            // $manager = $this->getDoctrine()->getManager();
            // $manager->persist($anneePastoraleToUpdate);
            $entitymanager->flush();
            return new JsonResponse(['ok' => true, 'message' => 'opération effectuée avec succès']);
        } catch (\Exception $e) {
            return new JsonResponse(['ok' => false, 'message' => $e->getMessage()]);
        }
    }

    #[Route('/GetBrancheUnique', name: 'GetBrancheUnique')]
    public function BrancheUnique(HttpFoundationRequest $request, BrancheRepository $repoBranche, SerializerInterface $serializer)
    {
        $id = $request->query->get("value");
        $result = $repoBranche->findOneBy(["id" => $id]);
        dump($result);
        $liste =  $serializer->serialize($result, 'json', ['groups' => 'branche']);
        return new JsonResponse(['ok' => true, 'data' => $liste]);
    }
    #[Route('/GetGroupeUnique', name: 'GetGroupeUnique')]
    public function GroupeUnique(HttpFoundationRequest $request, GroupeRepository $Rpgroupe, SerializerInterface $serializer, CommissariatDistrictRepository $repoDistrict)
    {
        try {
            $data = $request->query->get("value");
            $groupeUnique = $Rpgroupe->findOneBy(["id" => $data]);
            $qClass = new Classes\QueryClass($this->EntityManager);
            $GroupeUnique = $qClass->GetGroupeUnique($groupeUnique->getId());
            //get District
            //  $district =  $repoDistrict->findOneBy(["id"=>$districtId[0]]);

            // $groupeUnique->setGroupeId($districtId[0]);
            // var_dump($GroupeUnique);
           // $value = $serializer->serialize($groupeUnique, 'json');
            return new JsonResponse(['ok' => true, 'data' => $GroupeUnique]);
             //return new Response();
        } catch (\Exception $e) {
            return new JsonResponse(['ok' => false, 'message' => $e->getMessage()]);
             //return new Response();
        }
    }
    #[Route('/UpdateGroupe', name: 'UpdateGroupe')]
    public function UpdateGroupe(HttpFoundationRequest $request, GroupeRepository $repGroupe, EntityManagerInterface $entitymanager, CommissariatDistrictRepository $cdRepo,SluggerInterface $slugger):Response
    {
        try {

            $newGroupe = new Groupe();
            $newGroupe->setNom($request->get("nom"))
                ->setNickName($request->get("nickname"))
                ->setPhone1($request->get("phone1"))
                ->setPhone2($request->get("phone2"))
                ->setEmail($request->get("mail"))
                ->setSlogan("")
                ->setRegion($request->get("region"))
                ->setParoisse($request->get("paroisse"))
                ->setDateModification(new \DateTime());


            
            //file management
            $file = $request->files->get('image_path');

            //  $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            //  $safeFilename = $slugger->slug($originalFilename);
            //  $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();








            $baseDir = realpath(__DIR__ . '/../../img_logo');
            $fichier=$_FILES["fichier"]["name"];
            $real = realpath($_FILES["fichier"]["tmp_name"]);
            $extension = $_FILES["fichier"]["type"];
            $handle = fopen($_FILES["fichier"]["tmp_name"],'r');
            move_uploaded_file($_FILES["fichier"]["tmp_name"],$baseDir.'//'.$fichier);
            $newfile = $baseDir.'//'.$fichier;

           // dump($real);


            //var_dump($newfile);
            // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
            // $spreadsheet = $reader->load($newfile);
            // $highetsrow = $spreadsheet->getActiveSheet()->getHighestDataRow();
            // $highestColumn = $spreadsheet->getActiveSheet()->getHighestDataColumn();
            // $numberOfColumn = $this->MapAlphabeticLetter($highestColumn);








            //  $file->move(
            //     $this->getParameter('brochures_directory'),
            //     $newFilename
            //   );


            // $newGroupe->setFilename($newFilename);


            //get groupe to update
            $groupeToUpdate = $repGroupe->findOneBy(["id" => $request->get("id")]);
            if ($groupeToUpdate != null) {
                $nom = $groupeToUpdate->getNom() == $newGroupe->getNom() ? $groupeToUpdate->getNom() : $newGroupe->getNom();
                $nickname = $groupeToUpdate->getNickName() == $newGroupe->getNickName()? $groupeToUpdate->getNickName() : $newGroupe->getNickName();
                $phone1 =  $groupeToUpdate->getPhone1() == $newGroupe->getPhone1() ? $groupeToUpdate->getPhone1() : $newGroupe->getPhone1();
                $phone2 =  $groupeToUpdate->getPhone2() == $newGroupe->getPhone2()? $groupeToUpdate->getPhone2() : $newGroupe->getPhone2();
                $email =  $groupeToUpdate->getEmail() == $newGroupe->getEmail()? $groupeToUpdate->getEmail() : $newGroupe->getEmail();
                //  $slogan =  $groupeToUpdate->getSlogan() == $data["slogan"] ? $groupeToUpdate->getSlogan() : $data["slogan"];
                $paroisse =  $groupeToUpdate->getParoisse() ==$newGroupe->getParoisse() ? $groupeToUpdate->getParoisse() : $newGroupe->getParoisse();
                $region =  $groupeToUpdate->getRegion() == $newGroupe->getRegion()? $groupeToUpdate->getRegion() : $newGroupe->getRegion();
            }
            $groupeToUpdate->setFilename($fichier);
                //selected district
                $selecteDistrict = $cdRepo->findOneBy(["id"=>$request->get("District")]);
             $district = $groupeToUpdate->getCommissariatDistrict() == $selecteDistrict ? $groupeToUpdate->getCommissariatDistrict() : $selecteDistrict;


                $groupeToUpdate->setNom($nom);
                $groupeToUpdate->setNickName($nickname);
                $groupeToUpdate->setPhone1($phone1);
                $groupeToUpdate->setPhone2($phone2);
                $groupeToUpdate->setEmail($email);
                //  $groupeToUpdate->setSlogan($slogan);
                $groupeToUpdate->setParoisse($paroisse);
                $groupeToUpdate->setRegion($region);
                $groupeToUpdate->setDateModification(new \DateTime());
                $groupeToUpdate->setCommissariatDistrict($district);

                var_dump($groupeToUpdate);
           
             $entitymanager->flush();
             return new Response();
            //return new JsonResponse(['ok' => true, 'message' => 'opération effectuée avec succès']);
        } catch (\Exception $e) {
           //return new JsonResponse(['ok' => false, 'message' => $e->getMessage()]);
           return new Response();
        }
     
    }


    #[Route('/update_groupe_new', name: 'update_groupe_new')]
    public function update_groupe_new(HttpFoundationRequest $request, GroupeRepository $repGroupe, EntityManagerInterface $entitymanager, CommissariatDistrictRepository $cdRepo,SluggerInterface $slugger)
    {
        try{

    
        $newGroupe = new Groupe();
        $newGroupe->setNom($request->get("nom"))
            ->setNickName($request->get("nickname"))
            ->setPhone1($request->get("phone1"))
            ->setPhone2($request->get("phone2"))
            ->setEmail($request->get("mail"))
            ->setSlogan("")
            ->setRegion($request->get("region"))
            ->setParoisse($request->get("paroisse"))
            ->setDateModification(new \DateTime());

        $targetfile = __DIR__."/../../public/uploads/groupe";
        define ('SITE_ROOT', realpath(dirname(__FILE__)));
        $fichier=$_FILES["image_path"]["name"];
         $real = realpath($_FILES["image_path"]["tmp_name"]);
         $extension = $_FILES["image_path"]["type"];
         $handle = fopen($_FILES["image_path"]["tmp_name"],'r');
        if(move_uploaded_file($real,$targetfile.'/'. $fichier))   
        {
            dump("moved");
        }
        else
        {
            dump("unmoved");
        }
       //get groupe to update
       $groupeToUpdate = $repGroupe->findOneBy(["id" => $request->get("id")]);
       if ($groupeToUpdate != null) {
        $nom = $groupeToUpdate->getNom() == $newGroupe->getNom() ? $groupeToUpdate->getNom() : $newGroupe->getNom();
        $nickname = $groupeToUpdate->getNickName() == $newGroupe->getNickName()? $groupeToUpdate->getNickName() : $newGroupe->getNickName();
        $phone1 =  $groupeToUpdate->getPhone1() == $newGroupe->getPhone1() ? $groupeToUpdate->getPhone1() : $newGroupe->getPhone1();
        $phone2 =  $groupeToUpdate->getPhone2() == $newGroupe->getPhone2()? $groupeToUpdate->getPhone2() : $newGroupe->getPhone2();
        $email =  $groupeToUpdate->getEmail() == $newGroupe->getEmail()? $groupeToUpdate->getEmail() : $newGroupe->getEmail();
        //  $slogan =  $groupeToUpdate->getSlogan() == $data["slogan"] ? $groupeToUpdate->getSlogan() : $data["slogan"];
        $paroisse =  $groupeToUpdate->getParoisse() ==$newGroupe->getParoisse() ? $groupeToUpdate->getParoisse() : $newGroupe->getParoisse();
        $region =  $groupeToUpdate->getRegion() == $newGroupe->getRegion()? $groupeToUpdate->getRegion() : $newGroupe->getRegion();
       }
        $groupeToUpdate->setFilename($fichier);
        //selected district
        $selecteDistrict = $cdRepo->findOneBy(["id"=>$request->get("District")]);
     $district = $groupeToUpdate->getCommissariatDistrict() == $selecteDistrict ? $groupeToUpdate->getCommissariatDistrict() : $selecteDistrict;


        $groupeToUpdate->setNom($nom);
        $groupeToUpdate->setNickName($nickname);
        $groupeToUpdate->setPhone1($phone1);
        $groupeToUpdate->setPhone2($phone2);
        $groupeToUpdate->setEmail($email);
        //  $groupeToUpdate->setSlogan($slogan);
        $groupeToUpdate->setParoisse($paroisse);
        $groupeToUpdate->setRegion($region);
        $groupeToUpdate->setDateModification(new \DateTime());
        $groupeToUpdate->setCommissariatDistrict($district);

        dump($groupeToUpdate);
        $entitymanager->flush();
       // return new Response();
       return new JsonResponse(['ok' => true, 'message' => 'opération effectuée avec succès']);
    }
    catch (\Exception $e) {
       return new JsonResponse(['ok' => false, 'message' => $e->getMessage()]);
      // return new Response();
    }
    }

    #[Route('/Formation', name: 'Formation')]
    public function Formation(): Response
    {
        return $this->render('Configuration/Formation.html.twig', [
            'controller_name' => 'ConfigurationController',
        ]);
    }



    #[Route('/AddFormation', name: 'AddFormation')]
    public function AddFormation(\App\Repository\FormationRepository  $form, \Symfony\Component\HttpFoundation\Request $value): Response
    {
        try {
            $newFormation = new Formation();

            $fromjson = $value->request->get('value');
            $newFormation->setLibelle($fromjson["Libelle"]);
            $newFormation->setOrdre($fromjson["Ordre"]);




            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newFormation);
            $manager->flush();
            return new JsonResponse(["ok" => true, "data" => "Opération effectuée avec succès"]);
        } catch (\Exception $e) {
            return new JsonResponse(["ok" => true, "data" => $e->getMessage()]);
        }
    }

    #[Route('/GetListeFormation', name: 'GetListeFormation')]
    public function GetListeFormation(FormationRepository $repo, SerializerInterface $serializer)
    {
        $liste = $repo->findAll();

        $listeformation =  $serializer->serialize($liste, 'json', ['groups' => 'formation']);
        return new JsonResponse(["ok" => true, "data" => $listeformation]);
    }




    #[Route('/GetListDistrict', name: 'GetListDistrict')]
    public function GetListDistrict(CommissariatDistrictRepository $repo, SerializerInterface $serializer)
    {
        $liste = $repo->findAll();
        $listedistrict =  $serializer->serialize($liste, 'json', ['groups' => 'dst']);
        //dump($listedistrict);
        return new JsonResponse(["ok" => true, "data" => $listedistrict]);
        //return new Response();
    }



    #[Route('/IndexCommissariatDistrict', name: 'IndexCommissariatDistrict')]
    public function IndexCommissariatDistrict()
    {
        return $this->render('configuration/IndexCommissariatDistrict.html.twig', [
            'controller_name' => 'ConfigurationController',
        ]);
    }


    #[Route('/AddDistrict', name: 'AddDistrict')]
    public function AddDistrict(\Symfony\Component\HttpFoundation\Request $value, SluggerInterface $slugger)
    {

        //dump($value);

        $file = $value->files->get('img');

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        // dump($safeFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
        //  dump($newFilename);
        $file->move(
            $this->getParameter('brochures_directory'),
            $newFilename
        );
        $newrecord = new CommissariatDistrict();
        $newrecord->setNom($value->request->get("nom"));
        $newrecord->setTelephone("telephone");
        $newrecord->setEmail("email");
        $newrecord->setFilename($newFilename);
        // dump($newrecord->getNom());

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($newrecord);
        $manager->flush();
        return new JsonResponse(["ok" => true, "data" => "Opération effectuée avec succès"]);
        return new Response();
    }



    #[Route('/ConfigAdmin', name: 'ConfigAdmin')]
    public function ConfigAdmin(): Response
    {
        return $this->render('Connexion/ConfigAdmin.html.twig', [
            'controller_name' => 'ConfigurationController',
        ]);
    }




    #[Route('/GetDistrictUnique', name: 'GetDistrictUnique')]
    public function GetDistrictUnique(\Symfony\Component\HttpFoundation\Request $request, CommissariatDistrictRepository $repo, SerializerInterface $serializer)
    {

        $id = $request->query->get('value');
        $liste = $repo->findOneBy(["id" => $id]);
        //  $filename = $liste->getFilename();
        // $liste->setFilename( $this->getParameter('brochures_directory') ."//". $filename);
        $district =  $serializer->serialize($liste, 'json', ['groups' => 'dst']);
        return new JsonResponse(["ok" => true, "data" => $district]);
    }


    #[Route('/ListeTypeDocuments', name: 'ListeTypeDocuments')]
    public function ListeTypeDocuments(TypeDocumentRepository $repo, SerializerInterface $serializer)
    {

        $liste = $repo->findAll();
     
        $typedocuments =  $serializer->serialize($liste, 'json', ['groups' => 'typedoc']);
        return new JsonResponse(["ok" => true, "data" => $typedocuments]);
    }
} 
