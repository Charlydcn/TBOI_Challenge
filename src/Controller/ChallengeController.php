<?php

namespace App\Controller;

use App\Repository\ChallengeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChallengeController extends AbstractController
{
    #[Route('/challenge', name: 'app_challenge')]
    public function index(ChallengeRepository $challengeRepository): Response
    {
        $challenges = $challengeRepository->findBy([]);

        return $this->render('challenge/index.html.twig', [
            'challenges' => 'challenges',
        ]);
    }

    // #[Route('/challenge/{id}', name: 'show_challenge')]
    // public function show(Challenge $challenge): Response
    // {
    //     return $this->render('challenge/show.html.twig', [
    //         'challenge' => $challenge,
    //     ]);
    // }
}
