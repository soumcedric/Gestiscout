<?php

namespace App\Controller;

use App\Classes\QueryClass;
use App\Entity\Utilisateur;
use App\Entity\User;
use App\Repository\GroupeRepository;
use App\Repository\ResponsableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
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
    public function Addutilisateur(Request $req, UserPasswordEncoderInterface $encoder)
    {
        $fromJson = $req->request->get("value");
        $qClass = new QueryClass($this->em);
        $userExists = $qClass->CheckUserExist($fromJson["username"]);
        if ($userExists){
            return new Response('Cet utilisateur existe déjà',200);
        }else
        {
            $groupe = $this->session->get('groupeid');
            //get concerned group
            $ConnectedGroupe = $this->groupeLayer->findOneBy(["id"=>$groupe->getId()]);
            //get Concerned Responsable
            $ConcernedRespo = $this->respoLayer->findOneBy(["id"=>$fromJson["respoid"]]);
            $user = new User();

            $cryptedPass = $encoder->encodePassword($user, $fromJson["password"]);
            $user->setPassword($cryptedPass)
                ->setUsername($fromJson["username"])
                ->setGroupe($ConnectedGroupe)
                ->setRoles($fromJson["roles"])
                ->setResponsable($ConcernedRespo)
                ->setDateCreation(new \DateTime())
                ->setUserCreation("Admin");

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return new Response('success',200);
        }

    }


}