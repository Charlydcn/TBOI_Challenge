<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\VersusRepository;
use App\Repository\PlayChallengeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/profile/{id}', name: 'show_user')]
    public function show(
        User $user,
        PlayChallengeRepository $playChallengeRepository,
        VersusRepository $versusRepository): Response
    {

        $challengesPlayed = count($user->getChallengesPlayed());
        $challengesWon = count($playChallengeRepository->findBy(['user' => $user, 'completed' => true]));
        $x = ($challengesWon / $challengesPlayed) * 100;
        $challengeWinRate = number_format($x, 2);

        $versusPlayed = count($user->getVersusPlayed());
        $versusWon = count($versusRepository->findBy(['winner' => $user]));
        $y = ($versusWon / $versusPlayed) * 100;
        $versusWinRate = number_format($y, 2);


        return $this->render('user/show.html.twig', [
            'user' => $user,
            'challengeWinRate' => $challengeWinRate,
            'versusWinRate' => $versusWinRate,
        ]);
    }
}
