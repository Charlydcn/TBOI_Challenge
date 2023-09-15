<?php

namespace App\Controller;

use App\Repository\BossRepository;
use App\Repository\ChallengeRepository;
use App\Repository\CharacterRepository;
use App\Repository\RestrictionRepository;
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

    #[Route('/randomize', name: 'app_randomize')]
    public function randomize(
        Request $request,
        CharacterRepository $characterRepository,
        BossRepository $bossRepository,
        RestrictionRepository $restrictionRepository
        ): Response
    {
        // get all form data sent
        $formData = $request->request->all();

        // create empty array for every category
        $charactersIds = [];
        $bossesIds = [];
        $restrictionsIds = [];

        // list of all entites ****************************************************************
        $characters = $characterRepository->findAll();
        $bosses = $bossRepository->findAll();
        $restrictions = $restrictionRepository->findAll();
        // ************************************************************************************ 

        if(count($formData) > 1) {
            foreach($formData as $key => $value) {

                // ---------------------------------------------------------------------------------
                // character (if string $key starts by 'ch_' (position === 0) it's a character)
                if (strpos($key, 'ch_') === 0) {
                    if($this->isValidInt($value) === true) {
                        // add id to characters array
                        array_push($charactersIds, $value);
                    } else {
                        // incorrect id
                    }
                }
                // ---------------------------------------------------------------------------------

                // ---------------------------------------------------------------------------------
                // boss (if string $key starts by 'b_' (position === 0) it's a boss)
                if (strpos($key, 'b_') === 0) {
                    if($this->isValidInt($value) === true) {
                        // add id to bosses array
                        array_push($bossesIds, $value);
                    } else {
                        // incorrect id
                    }
                }
                // ---------------------------------------------------------------------------------

                // ---------------------------------------------------------------------------------
                // restriction (if string $key starts by 'r_' (position === 0) it's a restriction)
                if (strpos($key, 'r_') === 0) {
                    if($this->isValidInt($value) === true) {
                        // add id to restrictions array
                        array_push($restrictionsIds, $value);
                    } else {
                        // incorrect id
                    }
                }
                // ---------------------------------------------------------------------------------
                // restriction chance
                if (strpos($key, 'restr_chance') === 0) {
                    // if restriction chance isn't empty string (no user input)
                    if(!empty($value)) {
                        if($this->isValidInt($value) === true) {
                            // put the restriction chance in variable
                            $restrChance = $value;
                        } else {
                            // incorrect id
                        }
                    }
                }
                // ---------------------------------------------------------------------------------
            }

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
                $bossId = rand(1, count($bosses));
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
                foreach($restrictionsIds as $restrictionId) {
                    // if user entered a restriction chance in the input, custom chance, else, default value is 10%
                    // is user entered a restriction chance of 20 for example, random between 0 and 100, if result <= 20, we push the restriction
                    if(rand(0, 100) <= $restrChance) {
                        if(count($restrictionsIds) < 3) {
                            // get the object associated
                            $restriction = $restrictionRepository->findBy(['id' => $restrictionId]);
                            // and push it into $challRestrictions array to have a array full of objects
                            array_push($challRestrictions, $restriction);
                        }
                    }
                }
            }

        } else {
            // if no selection at all, randomize everything and give a random character/boss
            $characterId = rand(1, count($characters));
            $character = $characterRepository->findOneBy(['id' => $characterId]);

            $bossId = rand(1, count($bosses));
            $boss = $bossRepository->findOneBy(['id' => $bossId]);
            
            $challRestrictions = null;
        }

        return $this->render('home/index.html.twig', [
            'characters' => $characters,
            'bosses' => $bosses,
            'restrictions' => $restrictions,
            'character' => $character,
            'boss' => $boss,
            'challRestrictions' => $challRestrictions,
        ]);
    }

    function isValidInt($value)
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


    // function isValidInt($value)
    // {
    //     // check if value is a string
    //     if (is_string($value)) {

    //         // delete everything except numbers
    //         $numericValue = preg_replace('/[^0-9]/', '', $value);

    //         // si c'est vide, c'est qu'il n'y avait aucun chiffre alors return false
    //         if(empty($numericValue)) {
    //             return false;
    //         } else {
                
    //             // vérifier si c'est un entier avec FILTER_VALIDATE_INT
    //             $intValue = filter_var($numericValue, FILTER_VALIDATE_INT);
                
    //             // vérifier que la valeur passe le filtre et que le $numericValue est de 10 caractères maximum 
    //             if ($intValue !== false && strlen($numericValue) <= 10) {
    //                 return true;
    //             }
    //         }
    //     }
    //     return false;
    // }

    // #[Route('/challenge/{id}', name: 'show_challenge')]
    // public function show(Challenge $challenge): Response
    // {
    //     return $this->render('challenge/show.html.twig', [
    //         'challenge' => $challenge,
    //     ]);
    // }
}
