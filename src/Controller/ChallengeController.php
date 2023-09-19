<?php

namespace App\Controller;

use DateTime;
use App\Entity\Challenge;
use App\Form\ChallengeType;
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
        $challenges = $challengeRepository->findBy([]);

        return $this->render('challenge/index.html.twig', [
            'challenges' => 'challenges',
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
                
                return $this->redirectToRoute('new_challenge');
            }

            // if no boss selected, exit method
            if (count($form->get('characters')->getData()) < 1) {

                // add flash message of category warning
                $this->addFlash(
                    'warning',
                    'You have to select atleast 1 boss'
                );
                
                // and redirect
                return $this->redirectToRoute('new_challenge');
            }


            // restriction chance (mapped=false input) in variable
            // !! NEEDS TO BE SENT TO THE SHOW VIEW TO RANDOMIZE WHEN CHALLENGE IS PLAYED !!
            $restrictionChance = $form->get('restrChance')->getData();


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


            // persist = prepare
            $entityManager->persist($challenge);
            // flush = execute
            $entityManager->flush();

            return $this->redirectToRoute('app_challenge');
        }
        
        return $this->render('challenge/new.html.twig', [
            'newChallengeForm' => $form,
            'edit' => $challenge->getId()
        ]);
    }

    // #[Route('/new', name: 'new_challenge')]
    // public function test(
    //     Challenge $challenge = null,
    //     Request $request,
    //     CharacterRepository $characterRepository,
    //     BossRepository $bossRepository,
    //     RestrictionRepository $restrictionRepository
    //     ): Response
    // {
    //     // get all form data sent
    //     $formData = $request->request->all();

    //     // create empty array for every category
    //     $charactersIds = [];
    //     $bossesIds = [];
    //     $restrictionsIds = [];

    //     // list of all entites ****************************************************************
    //     $characters = $characterRepository->findAll();
    //     $bosses = $bossRepository->findBy(['timed' => 0]);
    //     $timedBosses = $bossRepository->findBy(['timed' => 1]);
    //     $restrictions = $restrictionRepository->findAll();
    //     // ************************************************************************************ 

    //     // $formData contains atleast submit even if user entered no data, so if $formData array > 1, handle data
    //     if(count($formData) > 1) {
    //         foreach($formData as $key => $value) {

    //             // ---------------------------------------------------------------------------------
    //             // character (if string $key starts by 'ch_' (position === 0) it's a character)
    //             if (strpos($key, 'ch_') === 0) {
    //                 if($this->isValidInt($value) === true) {
    //                     // add id to characters array
    //                     array_push($charactersIds, $value);
    //                 } else {
    //                     // incorrect id
    //                 }
    //             }
    //             // ---------------------------------------------------------------------------------

    //             // ---------------------------------------------------------------------------------
    //             // boss (if string $key starts by 'b_' (position === 0) it's a boss)
    //             if (strpos($key, 'b_') === 0) {
    //                 if($this->isValidInt($value) === true) {
    //                     // add id to bosses array
    //                     array_push($bossesIds, $value);
    //                 } else {
    //                     // incorrect id
    //                 }
    //             }
    //             // ---------------------------------------------------------------------------------

    //             // ---------------------------------------------------------------------------------
    //             // restriction (if string $key starts by 'r_' (position === 0) it's a restriction)
    //             if (strpos($key, 'r_') === 0) {
    //                 if($this->isValidInt($value) === true) {
    //                     // add id to restrictions array
    //                     array_push($restrictionsIds, $value);
    //                 } else {
    //                     // incorrect id
    //                 }
    //             }
    //             // ---------------------------------------------------------------------------------
    //             // restriction chance
    //             if (strpos($key, 'restr_chance') === 0) {
    //                 // if restriction chance isn't empty string (no user input)
    //                 if(!empty($value)) {
    //                     if($this->isValidInt($value) === true) {
    //                         // put the restriction chance in variable
    //                         $restrChance = $value;
    //                     } else {
    //                         // incorrect id
    //                     }
    //                 }
    //             }
    //             // ---------------------------------------------------------------------------------
    //         }

    //         // --------------------------------------------------------------------------------------------
    //         // CHALLENGE CREATION -------------------------------------------------------------------------
            
    //         $challenge = new Challenge();

    //         $challenge->setCreator();

    //         // --------------------------------------------------------------------------------------------
    //         // character ----------------------------------------------------------------------------------

    //         // if used selected atleast 1 character
    //         if (!empty($charactersIds)) {

    //             // for each characterId selected by user
    //             foreach($charactersIds as $characterId) {
    //                 // find the corresponding object 
    //                 $character = $characterRepository->findOneBy(['id' => $characterId]);
    //                 // and add it to newly instanciated $challenge
    //                 $challenge->addCharacter($character);
    //             }

    //         // if user selected no boss, add all bosses to challenge
    //         } else {

    //             // $bosses = all boss with attribute 'timed' = 0 (normal bosses)
    //             foreach($bosses as $boss) {
    //                 // find corresponding object
    //                 $boss = $bossRepository->findOneBy(['id' => $bossId]);
    //                 // and add it to newly instanciated $challenge
    //                 $challenge->addboss($boss);
    //             }
                
    //         }

    //         // --------------------------------------------------------------------------------------------
    //         // boss ---------------------------------------------------------------------------------------

    //         // if used selected atleast 1 boss
    //         if (!empty($bossesIds)) {

    //             // for each bossId selected by user
    //             foreach($bossesIds as $bossId) {
    //                 // find the corresponding object 
    //                 $boss = $bossRepository->findOneBy(['id' => $bossId]);
    //                 // and add it to newly instanciated $challenge
    //                 $challenge->addboss($boss);
    //             }

    //         // if user selected no boss, add all bosses to challenge
    //         } else {

    //             // $bosses = all boss with attribute 'timed' = 0 (normal bosses)
    //             foreach($bosses as $boss) {
    //                 // find corresponding object
    //                 $boss = $bossRepository->findOneBy(['id' => $bossId]);
    //                 // and add it to newly instanciated $challenge
    //                 $challenge->addboss($boss);
    //             }

    //         }

    //         // --------------------------------------------------------------------------------------------
    //         // restrictions -------------------------------------------------------------------------------

    //         // if used selected atleast 1 restriction
    //         if (!empty($restrictionsIds)) {

    //             // for each restrictionId selected by user
    //             foreach($restrictionsIds as $restrictionId) {
    //                 // get the corresponding object 
    //                 $restriction = $restrictionRepository->findOneBy(['id' => $restrictionId]);
    //                 // and add it to newly instanciated $challenge
    //                 $challenge->addrestriction($restriction);
    //             }

    //         } // if user selected no restriction, no restriction

    //         // --------------------------------------------------------------------------------------------

    //     } else {
    //         // if no selection at all, randomize everything and give a random character/boss
    //         $characterId = rand(1, count($characters));
    //         $character = $characterRepository->findOneBy(['id' => $characterId]);

    //         $bossId = rand(1, count($bosses));
    //         $boss = $bossRepository->findOneBy(['id' => $bossId]);
            
    //         $challRestrictions = null;
    //     }

    //     return $this->render('challenge/show.html.twig', [
    //         'character' => $character,
    //         'boss' => $boss,
    //         'challRestrictions' => $challRestrictions,
    //     ]);
    // }


    private function isValidInt($value)
    {
        // check if value is a string
        if (is_string($value)) {

            // Utiliser intval() pour convertir la chaîne en un entier
            $intValue = intval($value);

            // Vérifier si la conversion a réussi et que la longueur de la chaîne est inférieure ou égale à 10
            if ($intValue !== 0 && strlen($value) <= 10) {
                return true;
            }
        }
        return false;
    }


    #[Route('/challenge/{id}', name: 'show_challenge')]
    public function show(Challenge $challenge): Response
    {


        return $this->render('challenge/show.html.twig', [
            'challenge' => $challenge,
        ]);
    }


    #[Route('/challenge/{id}', name: 'play_challenge')]
    public function play(): Response
    {
        // ---------------------------------------------------------------------------------
            // character/boss generation with array_rand through user's selection or rand through all existing entities if no selection
            // ---------------------------------------------------------------------------------

            // if no character is selected, then random through all characters
            if(empty($charactersIds)) {
                $characterId = rand(1, count($characters));
                $character = $characterRepository->findOneBy(['id' => $characterId]);
            } else {
                // else, random through all ids given by user selection
                $characterId = $charactersIds[array_rand($charactersIds)];    
                $character = $characterRepository->findOneBy(['id' => $characterId]);
            }

            // if no boss is selected, then random through all characters
            if(empty($bossesIds)) {
                $bossId = rand(1, count(($bosses)));
                $boss = $bossRepository->findOneBy(['id' => $bossId]);
            } else {
                // else, random through all ids given by user selection
                $bossId = $bossesIds[array_rand($bossesIds)];    
                $boss = $bossRepository->findOneBy(['id' => $bossId]);
            }
            
            // ---------------------------------------------------------------------------------
            // ---------------------------------------------------------------------------------

            // restrictions is the only data that can be multiple
            $challRestrictions = [];

            // if $restrictionsIds isn't empty
            if(!empty($restrictionsIds)) {
                // foreach restriction selected by user
                $i = 0;
                foreach($restrictionsIds as $restrictionId) {
                    // if user entered a restriction chance in the input, custom chance, else, default value is 10%
                    // is user entered a restriction chance of 20 for example, random between 0 and 100, if result <= 20, we push the restriction
                    if(rand(0, 100) <= $restrChance) {
                        if($i < 3) {
                            // get the object associated
                            $restriction = $restrictionRepository->findBy(['id' => $restrictionId]);
                            // and push it into $challRestrictions array to have a array full of objects
                            array_push($challRestrictions, $restriction);
                        }
                    }
                    $i++;
                }
            }
    }
}
