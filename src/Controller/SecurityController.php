<?php

namespace App\Controller;

use App\Repository\GroupeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Util\YamlSourceManipulator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     */
    public function login(SessionInterface $session, UserRepository $UserRepo,Request $request): Response
    {

        dump($request);
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

       /**
     * @Route("/connexionlogin", name="connexionlogin")
     */
    public function connexion(Request $request, UserRepository $UserRepo,GroupeRepository $grouperepo)
    {
        
        $values = $request->request->get("value");
        $username = $values["username"];
        $password = $values["password"];
        $user = $UserRepo->findOneBy(["username"=>$username, "password"=>$password]);
        dump($user);
        if($user != null)
        {
            //get groupe
            $groupe = $user->getGroupe();
           // dump($groupe);
            $groupeinfo = $grouperepo->findOneBy(["id"=>$groupe->getId()]);
            $request->getSession()->set("id",$user->getId());
            $request->getSession()->set('nom',$user->getUserIdentifier());
            $request->getSession()->set('groupeid',$groupeinfo->getId());
            $url = $this->generateUrl("Dashboard");
            return new JsonResponse(["ok"=>true, "url"=>$url]);
        }
        else{
            return new JsonResponse(["ok"=>true]);
        }
        
      //  return new JsonResponse(["ok"=>true]);
     // return new Response();
    }
}
