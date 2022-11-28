<?php

namespace App\Security;

use App\Entity\Groupe;
use App\Entity\User;
use App\Entity\UserLogin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginCustomAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;
    private $target;
    private $userInfo;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
       // dump($request->attributes->get('_route'));
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
       // dump($request);
        $credentials = [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['username']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        // if($credentials['username']=='superadmin' || $credentials['password']=='superadmin')
        // {
          
        //     $this->userInfo = new UserLogin();
        //     $this->userInfo->setUsername("superadmin");
        //     $this->userInfo->setId(0000000000000000001);
        //    // $this->userInfo->setGroupe($user->getGroupe());
        //           $this->target="DashAdmin";
                   
        //           return new User();
                 
          
           
        // }
        // else
        // {               

            //     $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $credentials['username']]);
            //     if (!$user) {
            //         // fail authentication with a custom error
            //         throw new CustomUserMessageAuthenticationException('Username could not be found.');
            //     }
            //     $this->userInfo = new UserLogin();
            //     $this->userInfo->setUsername($user->getUsername());
            //     $this->userInfo->setId($user->getId());
            //     $this->userInfo->setGroupe($user->getGroupe());
            //    // $this->userInfo = $user;
                  
                

            //     if($user->getDistrict()!=null)
            //         $this->target="DistrictDash";
            //     else
            //         $this->target = "Dashboard";

            //         return $user;
        // } 

        $this->target="DashAdmin";
       // return $this->userInfo;        
       return $userProvider->loadUserByUsername($credentials['username']);
    //     $this->userInfo = new UserLogin();
    //     $this->userInfo->setUsername("superadmin");
    //     $this->userInfo->setId(000000000);
    //   //  $this->userInfo->setGroupe();
      
        
      
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
       return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
        //return true;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function getPassword($credentials): ?string
    {
        return $credentials['password'];
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        // if($this->userInfo->getUserName()!="superadmin")
        // {
        //     $request->getSession()->set("id",$this->userInfo->getId());
        //     $request->getSession()->set('nom',$this->userInfo->getUserName());
        //     $request->getSession()->set('groupeid',$this->userInfo->getGroupe());
        //     if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
        //         return new RedirectResponse($targetPath);
        //     }
        // }

        $user = $token->getUser();
            if($user->getUsername()!="superadmin")
            {
                  $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $user->getUsername()]);
                  $user->setlastconnection(new \DateTime());
                  $this->entityManager->persist($user);
                  $this->entityManager->flush();
                  //get groupe
               //   $groupe = $this->entityManager->getRepository(Groupe::class)->findOneBy([''])
                // if (!$user) {
                    $request->getSession()->set("id",$user->getId());
                    $request->getSession()->set('nom',"ddddd");
                    $request->getSession()->set('groupeid',$user->getGroupe());
                    
             }
       

        if($user->getFirstConnection())
        {
            $request->getSession()->set("firstconnection",true);
            $this->target=self::LOGIN_ROUTE;
        }
        else
        {
          
          
            if(in_array('ROLE_CONFIG',$user->getRoles(),true))
            {
                $this->target="DashAdmin";
            }
            else if(in_array('ROLE_DISTRICT_USER',$user->getRoles(),true)){
                $this->target="DistrictDash";
            }
            else if(in_array('ROLE_FORMATION',$user->getRoles(),true))
            {
                $this->target="DistrictDash"; 
            }
            else if(in_array('ROLE_CG',$user->getRoles(),true))
            {
                $this->target="Dashboard"; 
            }
        }
      
      
                 
      return new RedirectResponse($this->urlGenerator->generate($this->target));
        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
