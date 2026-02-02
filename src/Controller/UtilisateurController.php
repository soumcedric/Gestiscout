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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Psr\Log\LoggerInterface;

class UtilisateurController extends AbstractController
{
    private  $session;
    private $groupeLayer;
    private  $respoLayer;
    private $em;
    private $logger;
    
    function __construct(SessionInterface $session, GroupeRepository $groupe,ResponsableRepository $respo,EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->session = $session;
        $this->groupeLayer = $groupe;
        $this->respoLayer = $respo;
        $this->em = $em ;
        $this->logger = $logger;
    }

    #[Route('/utilisateur', name: 'utilisateur')]
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    #[Route('/Addutilisateur', name: 'Addutilisateur')]
    public function Addutilisateur(Request $request, UserPasswordHasherInterface $passHasher, ResponsableRepository $respoRepo, MailerInterface $mailer)
    {
        $this->logger->info("Entering Addutilisateur");
        try
        {
       
       // $fromJson = $req->request->get("value");
        $qClass = new QueryClass($this->em);
        $respoid = $request->request->get("respoid");
        $this->logger->info("Processing creation for respo id: " . $respoid);

        $ConcernedRespo = $this->respoLayer->findOneBy(["id" => $respoid]);
        if (!$ConcernedRespo) {
            $this->logger->error("Responsable not found with id: " . $respoid);
             return new JsonResponse(['ok' => false, 'message' => 'Responsable introuvable']);
        }

        $userExists = $qClass->CheckUserExist($ConcernedRespo->getEmail());
    
        if ($userExists) {
            $this->logger->warning("User already exists: " . $ConcernedRespo->getEmail());
            return new JsonResponse(['ok' => false, 'message' => 'Cet utilisateur existe déjà']);
        }          
            $groupe = $ConcernedRespo->getGroupe();
            //get concerned group
            $ConnectedGroupe = $this->groupeLayer->findOneBy(["id" => $groupe->getId()]);
           // dump($ConnectedGroupe);
            $role = $qClass->GetRespoRole($ConcernedRespo->getId());
            $this->logger->info("Role determined: " . $role);

            $user = new User();


            $randonpass = $this->RandomPassword();
            
            $cryptedPass = $passHasher->hashPassword($user, $randonpass);
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

            $this->logger->info("Persisting user: " . $user->getUsername());
            $this->em->persist($user);
            $this->em->flush();
            $this->logger->info("User persisted successfully");

            //send mail to the user with his default password
            //get email
            $respo = $respoRepo->findOneBy(["id" => $ConcernedRespo->getId()]);
            $email = $respo->getEmail();
            $nom = $respo->getNom();
            $prenoms = $respo->getPrenoms();

            $this->logger->info("Preparing email for: " . $email);

            $emailMessage = (new Email())
                ->from($this->getParameter('app.admin_email'))
                ->to($email)
                ->subject('Création de compte')
                ->html('Bonjour ' . $nom . ' ' . $prenoms . ', <br/>Votre inscription à la plateforme Gestiscout à été effectuée avec succès. <br\>Afin de vous connecter, veuillez utiliser
                    les identifiants ci-dessous: <br/>
                    nom utilisateur : ' . $user->getUserIdentifier()
                    . '<br/>
                    mot de passe: ' . $randonpass. "<br/><br/>
                    <i><strong>L'équipe GestiScout </strong></i>");

           // dump($email);
           try {
              $mailer->send($emailMessage);
              $this->logger->info("Email sent successfully");
           } catch(\Exception $e) {
               $this->logger->error("Failed to send email: " . $e->getMessage());
               // Note: we might not want to fail the whole request if email fails, but keeping original structure
           }
          

            return new JsonResponse(['ok' => true, 'message' => 'Compte créé avec succès']);
         
        }
        catch(\Exception $e)
        {
            $this->logger->error("Error in Addutilisateur: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return new JsonResponse(['ok' => false, 'message' => $e->getMessage()]);
           // dump($e->getMessage());
        }
    }




    #[Route('/AddUserFromDistrict', name: 'AddUserFromDistrict')]
    public function AddUserFromDistrict(Request $req, UserPasswordHasherInterface $encoder, ResponsableRepository $respo, DistrictRepository $district, ExercerFonctionRepository $exercer, MailerInterface $mailer)
    {
        $qClass = new QueryClass($this->em);
        //$fromJson = $req->request->get("value");
        $ConcernedRespo = $district->findOneBy(["id" => $req->request->get("respoid")]);
        dump($ConcernedRespo);
        $userExists = $qClass->CheckUserExist($ConcernedRespo->getEmail());
        if ($userExists){
            return new JsonResponse(['ok' => false, 'message' => 'Cet utilisateur existe déja!']);
        }else
        {

            
            //get excercer_fonction_id en fonction de districtid
          //  $exercerfonctiondistrict = $exercer->findOneBy(["District"=>$ConcernedRespo]);
          //  dump($ConcernedRespo);
            $qClass = new QueryClass($this->em);
            $role = $qClass->GetFunctionDistrict($req->request->get("respoid"));
            dump($ConcernedRespo->getEx); 

             $user = new User();


             $randonpass = $this->RandomPassword();
        
             $cryptedPass = $encoder->hashPassword($user, $randonpass);
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

            dump($user);
            $this->em->persist($user);
            $this->em->flush();
            //send mail to the user with his default password
             //get email
             $respo = $district->findOneBy(["id" => $ConcernedRespo->getId()]);
            // dump($respo);
             $email = $respo->getEmail();
            $nom = $respo->getNom();
             $prenoms = $respo->getPrenoms();

             $email = (new Email())
                ->from($this->getParameter('app.admin_email'))
                ->to($email)
                ->subject('Gestiscout - Création de compte')
                ->html('Bonjour ' . $nom . ' ' . $prenoms . ', <br/>Votre inscription à la plateforme Gestiscout à été effectuée avec succès. <br\>Afin de vous connecter, veuillez utiliser
                    les identifiants ci-dessous: <br/>
                    nom utilisateur : ' . $user->getUserIdentifier()
                    . '<br/>
                    mot de passe: ' . $randonpass. "<br/><br/>
                    <i><strong>L'équipe GestiScout </strong></i>");

            dump($email);

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