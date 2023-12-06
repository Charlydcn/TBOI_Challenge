<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use App\Repository\LikeRepository;
use App\Repository\VersusRepository;
use App\Repository\ChallengeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlayChallengeRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/profile/{id}', name: 'show_user')]
    public function show(
        User $user,
        LikeRepository $likeRepository,
        ChallengeRepository $challengeRepository,
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

        $challengesCreated = $challengeRepository->findBy(['creator' => $user]);

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'challengeWinRate' => $challengeWinRate,
            'versusWinRate' => $versusWinRate,
            'challengesLiked' => $challengesLiked,
            'challengesCreated' => $challengesCreated,
        ]);
    }

    #[Route('/edit-profile', name: 'edit_profile')]
    public function edit(
        Request $request,
        Security $security,
        EntityManagerInterface $entityManager,
    ): Response
    {
        
        $user = $security->getUser();

        if($user) {
            if($user->getDiscordId()) {
                $this->addFlash('error', 'As a Discord user, you can\'t edit your profile');

                return $this->redirectToRoute('show_user', [
                    'id' => $user->getId(),
                ]);
            }

            $form = $this->createForm(EditProfileType::class, $user);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();
    
                return $this->redirectToRoute('show_user', [
                    'id' => $user->getId(),
                ]);
            }
    
            return $this->render('user/edit_profile.html.twig', [
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('app_home');
        }
    }

    #[Route('/user/{id}/delete', name: 'delete_user')]
    public function deleteUser(
        User $user,
        Security $security,
        EntityManagerInterface $em): Response
    {
        if($user) {
            $em->remove($user);
            $em->flush();
    
            $this->addFlash('success', 'Account deleted successfully');
            
            return $this->redirectToRoute('app_home');    
        } else {
            $this->addFlash('error', 'This user doesn\'t exist (error #00002)');

            return $this->redirectToRoute('app_home');
        }
    }
}
