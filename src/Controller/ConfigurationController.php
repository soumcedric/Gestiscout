<?php

namespace App\Controller;

use App\Entity\Branche;
use App\Entity\JEUNE;

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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class ConfigurationController extends AbstractController
{
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
         public function GetListeAnnee(AnneePastoraleRepository $repo,SerializerInterface $serialiser)
         {
             $liste = $repo->findOneBy(["bActif"=>true]);

             $listeAnneePastorale =  $serialiser->serialize($liste,'json',["group"=>"readAnnee"]);

            return  new \Symfony\Component\HttpFoundation\Response($listeAnneePastorale,200);
         }


    #[Route('/AddAnnee', name: 'AddAnnee')]
    public function AddAnnee(\Symfony\Component\HttpFoundation\Request $value): Response
    {

        $NewYear = new AnneePastorale();
        $fromjson = $value->request->get('value');
        $date = $fromjson["Debut"];
        $code =$fromjson["Code"];
        $datedebut = new \DateTime($fromjson["Debut"]);
        $datefin = new \DateTime($fromjson["Fin"]);

        $currenttime = date('H:i:s \O\n d/m/Y');
        $NewYear->setCodeAnnee($fromjson["Code"])
                ->setDateDebut($datedebut)
                ->setDateFin($datefin)
                ->setBActif($fromjson["bActif"])
                ->setUserCreation("admin");
             $NewYear ->setDateCreation(new \DateTime());



        $manager = $this->getDoctrine()->getManager();
        $manager->persist($NewYear);
        $manager->flush();
        return  new \Symfony\Component\HttpFoundation\Response(true,200);
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
        $newFonction->setDateCreation(new \DateTime());
      //  $newFonction->setUserCreation("Admin");



        $manager = $this->getDoctrine()->getManager();
        $manager->persist($newFonction);
        $manager->flush();

        return  new \Symfony\Component\HttpFoundation\Response(true,200);
//        return $this->render('configuration/ListeFonction.html.twig', [
//            'controller_name' => 'ConfigurationController',
//        ]);
    }


    #[Route('/GetListeFonction', name: 'GetListeFonction')]
    public function GetListeFonction(\App\Repository\FONCTIONRepository  $repo,SerializerInterface $serializer): Response
    {
        $listeFonction = $repo->findAll();

        $result = $serializer->serialize($listeFonction,'json',['groups' => 'fonction']);
        return  new \Symfony\Component\HttpFoundation\Response($result,200);

    }

    #[Route('/GetListBranche', name: 'GetListBranche')]
    public function GetListBranche(\App\Repository\BrancheRepository  $repo,NormalizerInterface $normalizer,SerializerInterface $serializer): Response
    {
        $listeBranche = $repo->findAll();
//        $listeNormalized =  $normalizer->normalize($listeBranche,null,["groups"=>"branche"]);//,null,['groups'=>'post:read']);
//        $result = json_encode($listeNormalized);
        $result = $serializer->serialize($listeBranche,'json',['groups'=>'branche']);
        return  new \Symfony\Component\HttpFoundation\Response($result,200);

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

        return  new \Symfony\Component\HttpFoundation\Response(true,200);
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
    public function AddGroupe(\Symfony\Component\HttpFoundation\Request $value): Response
    {

         $formJson=$value->request->get('value');
         $newGroupe = new Groupe();
         $newGroupe->setNom($formJson["nom"])
                   ->setNickName($formJson["nickname"])
                   ->setPhone1($formJson["phone1"])
                   ->setPhone2($formJson["phone2"])
                   ->setEmail($formJson["mail"])
                   ->setSlogan("")
                   ->setRegion($formJson["region"])
                   ->setParoisse($formJson["paroisse"]);


        $manager = $this->getDoctrine()->getManager();
        $manager->persist($newGroupe);
        $manager->flush();

        return  new \Symfony\Component\HttpFoundation\Response(true,200);
//        return $this->render('configuration/ListeFonction.html.twig', [
//            'controller_name' => 'ConfigurationController',
//        ]);
    }

    #[Route('/GetAnneePastoraleUnique', name: 'GetAnneePastoraleUnique')]
    public function GetUniqueAnneePastorale(\Symfony\Component\HttpFoundation\Request $value, \App\Repository\AnneePastoraleRepository  $repo,NormalizerInterface $normalizer): Response
    {
        $id = $value->get("value");
        $AneePastorale = $repo->findUniqueAnneePastorale($id);
        $listeNormalized =  $normalizer->normalize($AneePastorale);//,null,['groups'=>'post:read']);
        $result = json_encode($listeNormalized);
        return  new \Symfony\Component\HttpFoundation\Response($result,200);

    }




    #[Route('/GetListGroupe', name: 'GetListGroupe')]
    public function GetListGroupe(GroupeRepository $repo,NormalizerInterface $normalizer)
    {
        $liste = $repo->findAll();

        $listeNormalized =  $normalizer->normalize($liste,'json',['groups'=>'groupe']);//,null,['groups'=>'post:read']);
        $result = json_encode($listeNormalized);
        return  new \Symfony\Component\HttpFoundation\Response($result,200);
    }


    #[Route('/GetListeGenre', name: 'GetListeGenre')]
    public function GetListeGenre(GenreRepository $repo,SerializerInterface $serializer)
    {
        $liste = $repo->findAll();

        $listeGenre =  $serializer->serialize($liste,'json',['groups'=>'genre']);//,null,['groups'=>'post:read']);
       // $result = json_encode($listeGenre);
        return  new \Symfony\Component\HttpFoundation\Response($listeGenre,200);
    }


}
