<?php

namespace App\Controller;

use App\Entity\User;
use App\Classes\QueryClass;
use App\Entity\Utilisateur;
use App\Repository\DistrictRepository;
use App\Repository\ExercerFonctionRepository;
use Symfony\Component\Mime\Email;

use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ResponsableRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurController extends AbstractController
{
    private  $session;
    private $groupeLayer;
    private  $respoLayer;
    private $em;
    
    function __construct(SessionInterface $session, GroupeRepository $groupe,ResponsableRepository $respo,EntityManagerInterface $em)
    {
        $this->session = $session;
        $this->groupeLayer = $groupe;
        $this->respoLayer = $respo;
        $this->em = $em ;
    }

    #[Route('/utilisateur', name: 'utilisateur')]
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    #[Route('/Addutilisateur', name: 'Addutilisateur')]
    public function Addutilisateur(Request $req, UserPasswordEncoderInterface $encoder, ResponsableRepository $respoRepo, MailerInterface $mailer)
    {
        try
        {
       
        $fromJson = $req->request->get("value");
        $qClass = new QueryClass($this->em);
        $ConcernedRespo = $this->respoLayer->findOneBy(["id" => $fromJson["respoid"]]);
        $userExists = $qClass->CheckUserExist($ConcernedRespo->getEmail());
        if ($userExists) {
            return new JsonResponse(['ok' => false, 'message' => 'Cet utilisateur existe déjà']);
        } else {
                 //get Concerned Responsable
                
            //$groupe = $this->session->get('groupeid');
            $groupe = $ConcernedRespo->getGroupe();
            //get concerned group
            $ConnectedGroupe = $this->groupeLayer->findOneBy(["id" => $groupe->getId()]);
       
            $role = $qClass->GetRespoRole($ConcernedRespo->getId());
            dump($role);

            $user = new User();


            $randonpass = $this->RandomPassword();
            //dump($randonpass);
            $cryptedPass = $encoder->encodePassword($user, $randonpass);
            $roles = array($role);
            $user->setPassword($cryptedPass)
                ->setUsername($ConcernedRespo->getEmail())
                ->setGroupe($ConnectedGroupe)
                ->setRoles($roles)
                ->setResponsable($ConcernedRespo)
                ->setDateCreation(new \DateTime())
                ->setBActif(true)
                ->setFirstConnection(true)
                ->setUserCreation("Admin");

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            //send mail to the user with his default password
            //get email
            $respo = $respoRepo->findOneBy(["id" => $ConcernedRespo->getId()]);
            $email = $respo->getEmail();
            $nom = $respo->getNom();
            $prenoms = $respo->getPrenoms();

            $email = (new Email())
                ->from($this->getParameter('app.admin_email'))
                ->to($email)
                ->subject('Création de compte')
                ->html('Bonjour ' . $nom . ' ' . $prenoms . ', <br/>Votre inscription à la plateforme Gestiscout à été effectuée avec succès. <br\>Afin de vous connecter, veuillez utiliser
                    les identifiants ci-dessous: <br/>
                    nom utilisateur : ' . $user->getUsername()
                    . '<br/>
                    mot de passe: ' . $randonpass. "<br/><br/>
                    <i><strong>L'équipe GestiScout </strong></i>");


          $result =   $mailer->send($email);
          

            return new JsonResponse(['ok' => true, 'message' => 'Compte créé avec succès']);
        }
             
        }
        catch(\Exception $e)
        {
            return new JsonResponse(['ok' => false, 'message' => $e->getMessage()]);
            dump($e->getMessage());
        }
    }




    #[Route('/AddUserFromDistrict', name: 'AddUserFromDistrict')]
    public function AddUserFromDistrict(Request $req, UserPasswordEncoderInterface $encoder, ResponsableRepository $respo, DistrictRepository $district, ExercerFonctionRepository $exercer, MailerInterface $mailer)
    {
        $qClass = new QueryClass($this->em);
        $fromJson = $req->request->get("value");
        $ConcernedRespo = $district->findOneBy(["id" => $fromJson["respoid"]]);
        $userExists = $qClass->CheckUserExist($ConcernedRespo->getEmail());
        if ($userExists){
            return new Response('Cet utilisateur existe déjà',200);
        }else
        {

            
            //get excercer_fonction_id en fonction de districtid
          //  $exercerfonctiondistrict = $exercer->findOneBy(["District"=>$ConcernedRespo]);
          //  dump($ConcernedRespo);
            $qClass = new QueryClass($this->em);
            $role = $qClass->GetFunctionDistrict($fromJson["respoid"]);
            //dump($info);
        //     $role = $qClass->GetRespoRole($ConcernedRespo->getId());
        //     //dump($role);

             $user = new User();


             $randonpass = $this->RandomPassword();
        //     //dump($randonpass);
             $cryptedPass = $encoder->encodePassword($user, $randonpass);
             $roles = array($role);
             $user->setPassword($cryptedPass)
                ->setUsername($ConcernedRespo->getEmail())
                //->setGroupe(null)
                ->setRoles($roles)
                ->setDistrict($ConcernedRespo)               
                ->setDateCreation(new \DateTime())
                ->setBActif(true)
                ->setFirstConnection(true)
                ->setUserCreation("Admin");

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
        //     //send mail to the user with his default password
        //     //get email
             $respo = $district->findOneBy(["id" => $ConcernedRespo->getId()]);
            // dump($respo);
             $email = $respo->getEmail();
            $nom = $respo->getNom();
             $prenoms = $respo->getPrenoms();

             $email = (new Email())
                ->from($this->getParameter('app.admin_email'))
                ->to($email)
                ->subject('Création de compte')
                ->html('Bonjour ' . $nom . ' ' . $prenoms . ', <br/>Votre inscription à la plateforme Gestiscout à été effectuée avec succès. <br\>Afin de vous connecter, veuillez utiliser
                    les identifiants ci-dessous: <br/>
                    nom utilisateur : ' . $user->getUsername()
                    . '<br/>
                    mot de passe: ' . $randonpass. "<br/><br/>
                    <i><strong>L'équipe GestiScout </strong></i>");

           $result =   $mailer->send($email);
          

            return new JsonResponse(['ok' => true, 'message' => 'Compte créé avec succès']);

           return new Response();
        }

    }


    function RandomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }


}