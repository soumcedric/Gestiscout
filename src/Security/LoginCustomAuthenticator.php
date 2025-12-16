<?php

namespace App\Security;

use App\Entity\Groupe;
use App\Entity\User;
use App\Entity\UserLogin;
use App\Repository\DistrictRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginCustomAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private $entityManager;
    private $urlGenerator;
    private $target;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('username', '');
        $password = $request->request->get('password', '');
        $csrfToken = $request->request->get('_csrf_token');

        $request->getSession()->set('_security.last_username', $username);

        return new Passport(
            new UserBadge($username),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $csrfToken),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $user = $token->getUser();
        
        if (!$user instanceof User) {
            throw new CustomUserMessageAuthenticationException('Invalid user type.');
        }

        // Mise à jour de la dernière connexion
        $userEntity = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $user->getUserIdentifier()]);
        
        if ($userEntity) {
            $userEntity->setLastConnection(new \DateTime());
            $this->entityManager->persist($userEntity);
            $this->entityManager->flush();

            // Enregistrer les données en session
            $request->getSession()->set("USER", $userEntity);
            $request->getSession()->set("id", $userEntity->getId());
            $request->getSession()->set('nom', $userEntity->getUserIdentifier());

            if ($userEntity->getGroupe() != null) {
                $request->getSession()->set('groupeid', $userEntity->getGroupe());
                $request->getSession()->set('entite', '1'); // entité connectée groupe => 1
            } else {
                $request->getSession()->set('districtid', $userEntity->getDistrict());
                $request->getSession()->set('entite', '2'); // entité connectée district => 2
            }
        }

        // Gestion de la première connexion
        if ($userEntity && $userEntity->getFirstConnection()) {
            $request->getSession()->set("firstconnection", true);
            $this->target = self::LOGIN_ROUTE;
        } else {
            // Déterminer la cible en fonction des rôles
            $this->target = $this->determineTargetByRoles($userEntity->getRoles());
        }

        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate($this->target));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

    private function determineTargetByRoles(array $roles): string
    {
        if (in_array('ROLE_CONFIG', $roles, true)) {
            return "DashAdmin";
        }
        if (in_array('ROLE_DISTRICT_USER', $roles, true)) {
            return "DistrictDash";
        }
        if (in_array('ROLE_DISTRICT_CONFIG', $roles, true)) {
            return "districtconfig";
        }
        if (in_array('ROLE_FORMATION', $roles, true)) {
            return "DistrictDash";
        }
        if (in_array('ROLE_CG', $roles, true)) {
            return "Dashboard";
        }
        if (in_array('ROLE_CD_FINANCE', $roles, true)) {
            return "Caisse";
        }

        // Route par défaut
        return "Dashboard";
    }
}