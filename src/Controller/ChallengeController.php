<?php

namespace App\Controller;

use DateTime;
use App\Entity\Like;
use App\Entity\Versus;
use App\Entity\Challenge;
use App\Entity\PlayVersus;
use App\Form\ChallengeType;
use App\Entity\PlayChallenge;
use App\Form\PlayChallengeType;
use App\Repository\LikeRepository;
use App\Repository\VersusRepository;
use App\Repository\ChallengeRepository;
use App\Controller\RandomizerController;
use App\Repository\PlayVersusRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlayChallengeRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChallengeController extends AbstractController
{
    #[Route('/challenges', name: 'challenges')]
    public function index(ChallengeRepository $challengeRepository): Response
    {
        $challenges = $challengeRepository->findAll();

        return $this->render('challenge/index.html.twig', [
            'challenges' => $challenges,
        ]);
    }

    #[Route('/challenge/new', name: 'new_challenge')]
    #[Route('/challenge/{id}/edit', name: 'edit_challenge')]
    public function new(
        Challenge $challenge = null,
        Request $request,
        EntityManagerInterface $entityManager,
        Security $security,
        RandomizerController $randomizerController): Response
    {
        if (!$challenge) {
            $challenge = new Challenge();
        }
        
        // create form from ChallengeType FormType
        $form = $this->createForm(ChallengeType::class, $challenge);

        //  handle request : get form's corresponding superglobal ($_POST or $_GET) to handle form request
        $form->handleRequest($request);
        
        // if form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {

            // saveChall checkbox, if true, create Challenge entity, else, just randomizer user's selection
            $saveChall = $form->get('saveChall')->getData();

            // restriction chance (x% chance of each restrictions to occur)
            $restrictionsChance = $form->get('restrictionsChance')->getData();

            // hydrate new challenge with form data
            $challenge = $form->getData();

            // if winstreak checkbox isn't checked, set challenge winstreak attribute to 0
            // (because you can check winstreak, put a value, then uncheck it, but the value of the input still remains)
            if ($form->get('streakCheckbox')->getData() === false) {
                $challenge->setStreak(0);
            }

            // if user checked $saveChall, create the challenge
            if($saveChall) {
                // add creationDate (current date)
                $challenge->setCreationDate(new DateTime);
    
                // find current user with Security's method getUser()
                $user = $security->getUser();
                // and set current user to challenge creator (you have to be logged in to create a challenge)
                $challenge->setCreator($user);
    
                // persist = prepare object to be saved on database
                $entityManager->persist($challenge);
                // flush = execute the queries to save object
                $entityManager->flush();
    
                // redirect to challenge created, passing challenge id to show the created challenge
                return $this->redirectToRoute('show_challenge', [
                    'id' => $challenge->getId(),
                ]);

            // else, just randomize
            } else {
                $r = $randomizerController->randomize($challenge);

                return $this->render('randomizer/result.html.twig', [
                    'character' => $r['character'],
                    'boss' => $r['boss'],
                    'restrictions' => $r['restrictions'],
                ]);
            }

        }
        
        return $this->render('challenge/new.html.twig', [
            'newChallengeForm' => $form,
            'edit' => $challenge->getId()
        ]);
    }


    #[Route('/challenge/{id}', name: 'show_challenge')]
    public function show(
        Challenge $challenge,
        Security $security,
        PlayChallengeRepository $playChallengeRepository,
        LikeRepository $likeRepository): Response
    {

        // find current user with Security's method getUser()
        $user = $security->getUser();
        
        if($user) {
            $userLike = $likeRepository->findBy(['creator' => $user, 'challenge' => $challenge]);
            $userLike ? $liked = true : $liked = false;
        } else {
            $liked = false;
        }

        $winners = $playChallengeRepository->findBy(['challenge' => $challenge->getId(), 'completed' => true]);
        $bestsRuns = $playChallengeRepository->findBestRuns($challenge->getId(), 10);


        return $this->render('challenge/show.html.twig', [
            'challenge' => $challenge,
            'winners' => $winners,
            'liked' => $liked,
            'bestsRuns' => $bestsRuns,
        ]);
    }
    

    #[Route('/challenge/play/{challengeId}/{versusId?}', name: 'play_challenge')]
    public function play(
        #[MapEntity(id: 'challengeId')] Challenge $challenge,
        #[MapEntity(id: 'versusId')] ?Versus $versus,

        PlayChallenge $playChallenge = null,
        PlayVersus $playVersus = null,
        PlayVersusRepository $playVersusRepository,
        Security $security,
        Request $request,
        EntityManagerInterface $entityManager,
        ChallengeRepository $challengeRepository,
        VersusRepository $versusRepository,
        RandomizerController $randomizerController,
    ): Response {

        // call randomize() custom method to randomize on Challenge's collections
        $result = $randomizerController->randomize($challenge);

        // Character's index in $result returned array is 0, boss is 1, restrictions is 2 (restrictions is an array)
        $character = $result['character'];
        $boss = $result['boss'];
        $restrictions = [];

        // push every restriction in restrictions array
        foreach($result['restrictions'] as $restriction) {
            array_push($restrictions, $restriction);
        }

        // ***********************************************************************************************************
        // FORM HANDLING WHEN USER WIN THE CHALLENGE *****************************************************************

        $playChallenge = new PlayChallenge;

        // create playChallenge object through PlayChallengeType
        $playChallengeForm = $this->createForm(PlayChallengeType::class, $playChallenge);

        $playChallengeForm->handleRequest($request);

        // find current user with Security's method getUser()
        $user = $security->getUser();

        if ($versus) {

            // get datetime from now
            $now = new DateTime();

            // if the versus hasn't started yet, redirect
            if($versus->getStartDate() > $now) {
                $this->addFlash('error', 'This versus hasn\'t started yet');
    
                return $this->redirectToRoute('show_versus', [
                    'id' => $versus->getId(),
                ]);
            }

            // if versus has an endDate, and it is prior to $now, redirect
            if($versus->getEndDate() && $versus->getEndDate() < $now) {
                $this->addFlash('error', 'Sorry, you can\'t join this versus anymore');
    
                return $this->redirectToRoute('show_versus', [
                    'id' => $versus->getId(),
                ]);
            }

            // if the versus has limited slots, check if there is still
            if($versus->getSlots()) {
                // get the amount of availables slots in the challenge
                $slotsAvailables = $versus->getSlots() - count($versus->getPlayers());
    
                // if no slots, flash msg + redirect
                if($slotsAvailables <= 0) {
                    $this->addFlash('error', 'Sorry, this versus is full');
    
                    return $this->redirectToRoute('show_versus', [
                        'id' => $versus->getId(),
                    ]);
                }
            }

            // try to find a playVersus object with this versus and the current user who's trying to play
            $userAlreadyPlayed = $playVersusRepository->findBy(['user' => $user, 'versus' => $versus]);

            // if user already played the versus, prevent him from playing again (only 1 try per versus participant)
            if ($userAlreadyPlayed) {
                $this->addFlash('error', 'You can\'t play a Versus twice');

                return $this->redirectToRoute('show_versus', [
                    'id' => $versus->getId(),
                ]);
            }
        }

        if ($playChallengeForm->isSubmitted() && $playChallengeForm->isValid()) {


            // create playChallenge object
            $playChallenge->setCompleted(true);
            $playChallenge->setPlayDate(new DateTime);
            $playChallenge->setChallenge($challenge);
            $playChallenge->setUser($user);
            
            // add current user to challenge players
            $challenge->addPlayer($playChallenge);

            // +1 to user personnal win-streak if user is logged in
            $user ? $user->setWinStreak($user->getWinStreak() + 1) : "";

            // if user's new win streak > user's best win streak, update his best win streak
            if($user && $user->getWinStreak() > $user->getBestWinStreak()) {
                $user->setBestWinStreak($user->getWinStreak());
            }


        # VERIFIER QUE L'UTILISATEUR N'A PAS DEJA JOUE AU CHALLENGE, ON PEUT QUE Y JOUER UNE FOIS ET FAIRE SON TEMPS SINON C'EST CHIANT #}

            // if user came from a versus, create playVersus object
            if ($versus) {

                $playVersus = new PlayVersus;

                $playVersus->setCompleted(true);
                if ($playChallenge->getCompletionTime()) {
                    $playVersus->setCompletionTime($playChallenge->getCompletionTime());
                }
                $playVersus->setPlayDate(new DateTime);
                $playVersus->setVersus($versus);
                $playVersus->setUser($user);


                // if versus already have a winner, get the playVersus object of the winner to find the best completion time of
                // the versus, then compare it with the current player
                if ($versus->getWinner()) {
                    $winnerPlayVersus = $playVersusRepository->findOneBy(['user' => $versus->getWinner(), 'versus' => $versus]);

                    $i = $winnerPlayVersus->getCompletionTime();
                    $bestVersusTime = $i->format('H:i:s');

                    // if current player completed the challenge faster than the actual best time of the versus,
                    if($bestVersusTime < $playVersus->getCompletionTime()) {
                        // set the new player as new winner of the versus
                        $versus->setWinner($playVersus->getUser());
                    }
                } else {
                    // if challenge had no winner, set current player as winner
                    $versus->setWinner($user);
                }

                // add current user to challenge players
                $versus->addPlayer($playVersus);

                // persist new PlayVersus object in database
                $entityManager->persist($playVersus);
                
            }

            // persist new PlayChallenge object in database
            $entityManager->persist($playChallenge);

            // flush changes
            $entityManager->flush();    
            
            if ($versus) {
                return $this->redirectToRoute('show_versus', [
                    'id' => $versus->getId(),
                ]);
            }

            return $this->redirectToRoute('show_challenge', [
                'id' => $challenge->getId(),
            ]);

        }
        // -----------------------------------------------------------------------------------------------------------
        // -----------------------------------------------------------------------------------------------------------
        
        return $this->render('challenge/play.html.twig', [
            'playChallenge' => $playChallenge,
            'playChallengeForm' => $playChallengeForm,
            'challenge' => $challenge,
            'character' => $character,
            'boss' => $boss,
            'restrictions' => $restrictions,
            'versus' => $versus,
        ]);
    }

    #[Route('/challenge/loose/{challengeId}/{versusId?}', name: 'loose_challenge')]
    public function loose(
        #[MapEntity(id: 'challengeId')]Challenge $challenge,
        #[MapEntity(id: 'versusId')] ?Versus $versus,
        PlayChallenge $playChallenge = null,
        Security $security,
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
            $playChallenge = new PlayChallenge;

            // find current user with Security's method getUser()
            $user = $security->getUser();

            $playChallenge->setCompleted(false);
            $playChallenge->setPlayDate(new DateTime);
            $playChallenge->setChallenge($challenge);
            $playChallenge->setUser($user);

            // add current user to challenge players
            $challenge->addPlayer($playChallenge);

            // reset user's win streak to 0 (if user is logged in)
            $user ? $user->setWinStreak(0) : "";

            // if user came from a versus, create playVersus object
            if ($versus) {
                $playVersus = new PlayVersus;

                $playVersus->setCompleted(false);
                $playVersus->setPlayDate(new DateTime);
                $playVersus->setVersus($versus);
                $playVersus->setUser($user);

                
                // add current user to challenge players
                $versus->addPlayer($playVersus);

                // persist new PlayVersus object in database
                $entityManager->persist($playVersus);
                
            }

            // persist new PlayChallenge object in database
            $entityManager->persist($playChallenge);
            // flush changes
            $entityManager->flush();

            if ($versus) {
                // redirect to versus played
                return $this->redirectToRoute('show_versus', [
                    'id' => $versus->getId(),
                ]);
            }

            // redirect to challenge created
            return $this->redirectToRoute('show_challenge', [
                'id' => $challenge->getId(),
            ]);
    }

    #[Route('/challenge/like/{id}', name: 'like_challenge')]
    public function like(
        Challenge $challenge,
        Security $security,
        LikeRepository $likeRepository,        
        EntityManagerInterface $entityManager,
        ): Response
    {
        // find current user with Security's method getUser()
        $user = $security->getUser();

        // try to find an existing like of the user on this challenge
        $existingLike = $likeRepository->findBy(['creator' => $user, 'challenge' => $challenge]);

        // if user liked the challenge and clicks on the heart, delete the like
        if($existingLike) {
            $entityManager->remove($existingLike[0]);
            
        // else, create the like
        } else {
            $like = new Like;
    
            $like->setCreator($user);
            $like->setChallenge($challenge);
    
            $challenge->addLike($like);
    
            $entityManager->persist($like);
        }

        $entityManager->flush();


        return $this->redirectToRoute('show_challenge', [
            'id' => $challenge->getId(),
        ]);
    }

}
