<?php

namespace App\Controller;

use App\Repository\BossRepository;
use App\Repository\CharacterRepository;
use App\Repository\RestrictionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    #[Route('/')]
    public function index(CharacterRepository $characterRepository, BossRepository $bossRepository, RestrictionRepository $restrictionRepository): Response
    {
        $characters = $characterRepository->findAll();
        $bosses = $bossRepository->findBy(['timed' => 0]);
        $timedBosses = $bossRepository->findBy(['timed' => 1]);
        $restrictions = $restrictionRepository->findAll();

        return $this->render('home.html.twig', [
            'characters' => $characters,
            'bosses' => $bosses,
            'timedBosses' => $timedBosses,
            'restrictions' => $restrictions,
        ]);
    }

    #[Route('/terms-of-services', name: 'terms')]
    public function renderTermsOfServiceView(): Response
    {
        return $this->render('terms_of_service.html.twig');
    }

    #[Route('/privacy-policy', name: 'privacy_policy')]
    public function renderPrivacyPolicyView(): Response
    {
        return $this->render('privacy_policy.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function renderContactView(): Response
    {
        return $this->render('contact.html.twig');
    }
}
