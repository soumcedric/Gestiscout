<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class LoginCustomController extends AbstractController
{
    private $urlGenerator;
    private $em;

    function __construct(UrlGeneratorInterface $urlGenerator, EntityManagerInterface $em)
    {
        $this->urlGenerator = $urlGenerator;
        $this->em = $em;
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, SessionInterface $session): Response
    {
        $firstconnection = $session->get('firstconnection');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
            
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error, 
            'firstconnection' => $firstconnection,
            'errorupdate' => null
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/UpdatePassword', name: 'UpdatePassword')]
    public function UpdatePassword(
        UserPasswordHasherInterface $passwordHasher, 
        AuthenticationUtils $authenticationUtils,
        SessionInterface $session, 
        Request $req, 
        UserRepository $userRep, 
        UrlGeneratorInterface $urlGenerator
    ): Response
    {
        $username = $req->request->get('username');
        $oldpassword = $req->request->get('password');
        $newpassword = $req->request->get('newPassword');
        $firstconnection = false;
        $user = $userRep->findOneBy(["username" => $username]);
        $error = "Nom Utilisateur introuvable!";
        
        if ($user != null) {
            // Vérifier l'ancien mot de passe
            if (!$passwordHasher->isPasswordValid($user, $oldpassword)) {
                $error = "Ancien mot de passe incorrect";
            } else {
                // Hasher le nouveau mot de passe
                $newHashedPassword = $passwordHasher->hashPassword($user, $newpassword);
                
                // Modifier le mot de passe et le firstconnection to false
                $user->setPassword($newHashedPassword)
                     ->setFirstConnection(false)
                     ->setLastConnection(new \DateTime());

                $this->em->persist($user);
                $this->em->flush();

                return new RedirectResponse($this->urlGenerator->generate($this->getTarget($user->getRoles())));
            }
        }

        return $this->render('security/login.html.twig', [
            'last_username' => "", 
            'errorupdate' => $error, 
            'error' => null, 
            'firstconnection' => $firstconnection
        ]);
    }

    function getTarget($roles)
    {
        $target = null;

        foreach ($roles as $r) {
            if (strval($r) == "ROLE_CONFIG") {
                $target = "DashAdmin";
            } else if (strval($r) == "ROLE_DISTRICT_USER") {
                $target = "DistrictDash";
            } else if (strval($r) == "ROLE_FORMATION") {
                $target = "DistrictDash"; 
            } else if (strval($r) == "ROLE_CG") {
                $target = "Dashboard"; 
            } else if (strval($r) == "ROLE_CD_FINANCE") {
                $target = "Caisse"; 
            }
        }

        return strval($target);
    }
}