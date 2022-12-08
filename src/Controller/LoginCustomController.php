<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\MakerBundle\Str;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginCustomController extends AbstractController
{
    private $urlGenerator;

    function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils,SessionInterface $session): Response
    {
        
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one

        $firstconnection = $session->get('firstconnection');
        dump($authenticationUtils);
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
            
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'firstconnection'=>$firstconnection,"errorupdate"=>null]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


     /**
     * @Route("/UpdatePassword", name="UpdatePassword")
     */
    public function UpdatePassword(UserPasswordEncoderInterface $encoder, AuthenticationUtils $authenticationUtils,SessionInterface $session, Request $req, UserRepository $userRep, UrlGeneratorInterface $urlGenerator): Response
    {
        
        
        $username = $req->request->get('username');
        $oldpassword = $req->request->get('password');
        $newpassword = $req->request->get('newPassword');
        $firstconnection =false;
        $user = $userRep->findOneBy(["username"=>$username]);
        $error = "Nom Utilsateur introuvable!";
        
        if($user != null)
        {
            
            $oldpass = $encoder->encodepassword($user,$oldpassword);
            $newpass = $encoder->encodepassword($user,$newpassword);
           //dump($oldpass, $user->getPassword());
            if(!$encoder->isPasswordValid($user,$oldpassword))
                $error ="Ancien mot de passe incorrect";
            else
                {
                    //modifier le mot de passe et le firstconnection to false
                    $user->setPassword($newpass)
                         ->setFirstConnection(false)
                         ->setLastConnection(new \DateTime());

                         $manager = $this->getDoctrine()->getManager();
                         $manager->persist($user);
                         $manager->flush();
                        //  $tar = $this->getTarget($user->getRoles());
                        //  dump($user);
                        //  dump($user->getRoles());
                         return new RedirectResponse($this->urlGenerator->generate( $this->getTarget($user->getRoles())));
                }
           
        }
       
        
        

        return $this->render('security/login.html.twig', ['last_username' => "", 'errorupdate' => $error, 'error'=>null, 'firstconnection'=>$firstconnection]);
    }


    function getTarget($roles)
    {
        dump($roles);
         $target = null;

        foreach( $roles as $r)
        {
            dump(strval($r));
            if( strval($r) == "ROLE_CONFIG")
            {
                $target="DashAdmin";
                
            }
            else if(strval($r) == "ROLE_DISTRICT_USER"){
                $target="DistrictDash";
                
            }
            else if(strval($r) == "ROLE_FORMATION")
            {
                $target="DistrictDash"; 
                
            }
            else if(strval($r) == "ROLE_CG")
            {
                $target="Dashboard"; 
               
            }
        }

        // if(in_array('ROLE_CONFIG',$roles,true))
        // {
        //     $this->target="DashAdmin";
        // }
        // else if(in_array('ROLE_DISTRICT_USER',$roles,true)){
        //     $this->target="DistrictDash";
        // }
        // else if(in_array('ROLE_FORMATION',$roles,true))
        // {
        //     $this->target="DistrictDash"; 
        // }
        // else if(in_array('ROLE_CG',$roles,true))
        // {
        //     $this->target="Dashboard"; 
        // }
      // dump("target ".$target);
        return strval($target);
    }
}
