<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\DiscordApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DiscordController extends AbstractController
{
    public function __construct(
        private readonly DiscordApiService $discordApiService
    )
    {
    }

    #[Route('/discord/connect', name: 'oauth_discord', methods: ['POST'])]
    public function connect(Request $request): Response
    {
        // récupération du token CSRF
        $token = $request->request->get('token');

        // vérification de la validité du token CSRF
        if ($this->isCsrfTokenValid('discord-auth', $token)) {
            // déclaration d'une variable 'discord-auth' comme 'true' en session 
            $request->getSession()->set('discord-auth', true);

            // déclaration du scope qui définiera les informations demandée à l'API Discord
            // (ici nous voulons le pseudo et l'adresse e-mail de l'utilisateur)
            $scope = ['identify', 'email'];

            // redirection vers la méthode getAuthorizationUrl() de la classe DiscordApiService.php
            // avec en paramètre de méthode notre variable $scope
            return $this->redirect($this->discordApiService->getAuthorizationUrl($scope));
        }

        return $this->redirectToRoute('app_home');
    }

    #[Route('/discord/auth', name: 'oauth_discord_auth')]
    public function auth(): Response
    {
        $this->addFlash('success', 'You are now logged in');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/discord/check', name: 'oauth_discord_check')]
    public function check(EntityManagerInterface $em, Request $request, UserRepository $userRepo): Response
    {
        $accessToken = $request->get('access_token');

        if (!$accessToken) {
            return $this->render('discord/check.html.twig');
        }

        $discordUser = $this->discordApiService->fetchUser($accessToken);

        $user = $userRepo->findOneBy(['discordId' => $discordUser->id]);

        if ($user) {
            return $this->redirectToRoute('oauth_discord_auth', [
                'accessToken' => $accessToken
            ]);
        }

        $user = new User();

        $user->setAccessToken($accessToken);
        $user->setUsername($discordUser->username);
        $user->setEmail($discordUser->email);
        $user->setDiscordId($discordUser->id);
        $user->setRegistrationDate(new DateTime);
        $user->setIcon('bean.webp');


        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('oauth_discord_auth', [
            'accessToken' => $accessToken
        ]);
    }
}