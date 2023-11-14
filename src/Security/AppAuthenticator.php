<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AppAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $roles = $token->getRoleNames();

        // Check if the user has the ROLE_ADMIN role
        if (in_array('ROLE_ADMIN', $roles)) {
            // Redirect admin to '/admin'
            return new RedirectResponse($this->urlGenerator->generate('app_admin'));
        }

        // Check if the user has the ROLE_CANDIDAT role
        if (in_array('ROLE_CANDIDAT', $roles)) {
            // Redirect candidat to '/candidats'
            return new RedirectResponse($this->urlGenerator->generate('app_candidats'));
        }

        // If the user doesn't have a specific role, redirect them to a default page
        // return new RedirectResponse($this->urlGenerator->generate('default_dashboard'));
        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    
    // public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    // {
    //     if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
    //         return new RedirectResponse($targetPath);
    //     }

    //     // For example:
    //     // return new RedirectResponse($this->urlGenerator->generate('some_route'));
    //     throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    // }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
