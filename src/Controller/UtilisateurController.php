<?php

namespace App\Controller;

use App\Entity\User;
use App\Classes\QueryClass;
use App\Entity\Utilisateur;
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
        $userExists = $qClass->CheckUserExist($fromJson["username"]);
        if ($userExists) {
            return new JsonResponse(['ok' => false, 'message' => 'Cet utilisateur existe déjà']);
        } else {
            $groupe = $this->session->get('groupeid');
            //get concerned group
            $ConnectedGroupe = $this->groupeLayer->findOneBy(["id" => $groupe->getId()]);
            //get Concerned Responsable
            $ConcernedRespo = $this->respoLayer->findOneBy(["id" => $fromJson["respoid"]]);
            $role = $qClass->GetRespoRole($ConcernedRespo->getId());
            //dump($role);

            $user = new User();


            $randonpass = $this->RandomPassword();
            //dump($randonpass);
            $cryptedPass = $encoder->encodePassword($user, $randonpass);
            $roles = array($role);
            $user->setPassword($cryptedPass)
                ->setUsername($fromJson["username"])
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
                ->from('scout2@scout.com')
                ->to($email)
                ->subject('Création de compte')
                ->html('Bonjour ' . $nom . ' ' . $prenoms . ', <br/>Votre inscription à la plateforme Gestiscout à été effectuée avec succès. <br\>Afin de vous connecter, veuillez utiliser
                    les identifiants ci-dessous: <br/>
                    nom utilisateur : ' . $user->getUsername()
                    . '<br/>
                    mot de passe: ' . $randonpass);

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
    public function AddUserFromDistrict(Request $req, UserPasswordEncoderInterface $encoder, ResponsableRepository $respo)
    {
        $qClass = new QueryClass($this->em);
        $fromJson = $req->request->get("value");
      //  var_dump($fromJson["respoid"]);
        //get user info from responsable table
        $ChoseRespo = $respo->findOneBy(["id"=>$fromJson["respoid"]]);
        //var_dump($ChoseRespo);
        $userExists = $qClass->CheckUserExist($fromJson["username"]);
        if ($userExists){
            return new Response('Cet utilisateur existe déjà',200);
        }else
        {
            //get full user information

            
            $user = new User();

            $cryptedPass = $encoder->encodePassword($user, $fromJson["password"]);
            //$cryptedPass = $encoder->encodePassword($user, '123456');
            $user->setPassword($cryptedPass)
                ->setUsername($fromJson["username"])
                ->setGroupe($ChoseRespo->getGroupe())
                ->setRoles($fromJson["roles"])
                ->setResponsable($ChoseRespo)
                ->setDateCreation(new \DateTime())
                ->setUserCreation("Admin");

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return new Response('success',200);
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