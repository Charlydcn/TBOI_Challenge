<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\LikeRepository;
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
        LikeRepository $likeRepository,
        PlayChallengeRepository $playChallengeRepository,
        VersusRepository $versusRepository): Response
    {

        $challengesPlayed = count($user->getChallengesPlayed());

        if ($challengesPlayed > 0) {
            $challengesWon = count($playChallengeRepository->findBy(['user' => $user, 'completed' => true]));
            $x = ($challengesWon / $challengesPlayed) * 100;
            $challengeWinRate = number_format($x, 2);
        } else {
            $challengesWon = 0;
            $challengeWinRate = 0;
        }

        $versusPlayed = count($user->getVersusPlayed());
        
        if($versusPlayed > 0) {
            $versusWon = count($versusRepository->findBy(['winner' => $user]));
            $y = ($versusWon / $versusPlayed) * 100;
            $versusWinRate = number_format($y, 2);
        } else {
            $versusWon = 0;
            $versusWinRate = 0;
        }

        $likes = $likeRepository->findBy(['creator' => $user]);
        $challengesLiked = [];

        foreach($likes as $like) {
            $challenge = $like->getChallenge();
            array_push($challengesLiked, $challenge);
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'challengeWinRate' => $challengeWinRate,
            'versusWinRate' => $versusWinRate,
            'challengesLiked' => $challengesLiked,
        ]);
    }
}
