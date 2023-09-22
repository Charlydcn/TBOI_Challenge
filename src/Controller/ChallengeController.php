<?php

namespace App\Controller;

use DateTime;
use App\Entity\Challenge;
use App\Form\ChallengeType;
use App\Entity\PlayChallenge;
use App\Repository\BossRepository;
use App\Repository\ChallengeRepository;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RestrictionRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChallengeController extends AbstractController
{
    #[Route('/challenge', name: 'app_challenge')]
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
        Security $security): Response
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

            // if no character selected, exit method
            if (count($form->get('characters')->getData()) < 1) {
                $this->addFlash(
                    'warning',
                    'You have to select atleast 1 character'
                );
                
                // redirect to challenge creation
                return $this->redirectToRoute('new_challenge');
            }

            // if no boss selected, exit method
            if (count($form->get('bosses')->getData()) < 1) {

                // add flash message of category warning
                $this->addFlash(
                    'warning',
                    'You have to select atleast 1 boss'
                );
                
                // redirect to challenge creation
                return $this->redirectToRoute('new_challenge');
            }


            // restriction chance (mapped=false input) in variable
            $restrictionsChance = $form->get('restrictionsChance')->getData();


            // hydrate new challenge with form data
            $challenge = $form->getData();


            // if winstreak checkbox isn't checked, set challenge winstreak attribute to 0 to make sure user can't
            // submit a winstreak if winstreak checkbox isn't checked
            if ($form->get('streakCheckbox')->getData() === false) {
                $challenge->setStreak(0);
            }


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
        }
        
        return $this->render('challenge/new.html.twig', [
            'newChallengeForm' => $form,
            'edit' => $challenge->getId()
        ]);
    }


    #[Route('/challenge/{id}', name: 'show_challenge')]
    public function show(Challenge $challenge): Response
    {
        return $this->render('challenge/show.html.twig', [
            'challenge' => $challenge,
        ]);
    }
    

    #[Route('/challenge/play/{id}', name: 'play_challenge')]
    public function play(
        Challenge $challenge,
        PlayChallenge $playChallenge = null,
        Security $security,
        EntityManagerInterface $entityManager): Response
    {
        // find current user with Security's method getUser()
        $user = $security->getUser();

        // create a PlayChallenge object to add it to challenge players
        $playChallenge = new PlayChallenge();

        $playChallenge->setChallenge($challenge);
        $playChallenge->setUser($user);
        $playChallenge->setCompleted(false);
        $playChallenge->setPlayDate(new DateTime);        

        // and add current user to challenge players
        $challenge->addPlayer($playChallenge);

        // persist new PlayChallenge object in database
        $entityManager->persist($playChallenge);
        // flush changes
        $entityManager->flush();


        // convert persistentCollection of characters to array of entities (can be done with 'getValues()' aswell)
        $charactersArray = $challenge->getCharacters()->toArray();
        // array_rand to get 1 entity randomized from new array
        $character = $charactersArray[array_rand($charactersArray)];


        // convert persistentCollection of boss to array of entities (can be done with 'getValues()' aswell)
        $bossesArray = $challenge->getBosses()->toArray();
        // array_rand to get 1 entity randomized from new array
        $boss = $bossesArray[array_rand($bossesArray)];


        // convert persistentCollection of restriction to array of entities
        $restrictionsArray = $challenge->getRestrictions()->toArray();

        $restrictionsChance = $challenge->getRestrictionsChance();

        // declare $restrictions as empty array to hydrate it with restrictions entities
        $restrictions = [];

        $countRestrictions = count($restrictionsArray);

        // if user selected atleast 1 restiction
        if ($countRestrictions > 0) {            
            // if user selected between 1 and 3 restrictions
            if ($countRestrictions >= 1 && $countRestrictions <= 3) {

                // shuffle array to randomize all restrictions
                shuffle($restrictionsArray);
                
                // for each restrictions
                foreach ($restrictionsArray as $restriction) {                    
                    // generate random number between 0 and 100 (with mt_rand() because it is faster than rand())                    
                    $randomNb = mt_rand(0, 100);

                    // if randomNb is <= than the challenge restrictions chance, push restriction in array
                    if ($randomNb <= $restrictionsChance) {
                        array_push($restrictions, $restriction);
                    }
                }
            } else {
                // if user selected more than 3 restrictions, shuffle array 
                shuffle($restrictionsArray);
                
                // slice 3 firsts restrictions of shuffled array
                $selectedRestrictions = array_slice($restrictionsArray, 0, 3);

                // for each restriction in sliced restrictions array
                foreach ($selectedRestrictions as $restriction) {
                    // generate random number between 0 and 100 (with mt_rand() because it is faster than rand())                    
                    $randomChance = mt_rand(0, 100);

                    // if randomNb is <= than the challenge restrictions chance, push restriction in array
                    if ($randomChance <= $restrictionsChance) {
                        array_push($restrictions, $restriction);
                    }
                }
            }
        }

        
        return $this->render('challenge/play.html.twig', [
            'challenge' => $challenge,
            'character' => $character,
            'boss' => $boss,
            'restrictions' => $restrictions,
        ]);
    }

    #[Route('/challenge/win/{id}', name: 'win_challenge')]
    public function win(Challenge $challenge): Response
    {
        dd('win');
    }

    #[Route('/challenge/loose/{id}', name: 'loose_challenge')]
    public function loose(Challenge $challenge): Response
    {
        dd('loose');
    }

}
