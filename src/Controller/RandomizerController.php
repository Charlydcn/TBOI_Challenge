<?php

namespace App\Controller;

use App\Entity\Challenge;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RandomizerController extends AbstractController
{
    public function randomize(Challenge $challenge)
    {
        // ***********************************************************************************************************
        // CHALLENGE CHARACTERS, BOSSES, RESTRICTIONS RANDOMIZATION (RESULT) *****************************************

        // -----------------------------------------------------------------------
        // character -------------------------------------------------------------

        // convert persistentCollection of characters to array of entities (can be done with 'getValues()' aswell)
        $charactersArray = $challenge->getCharacters()->toArray();
        // array_rand to get 1 entity randomized from new array
        $character = $charactersArray[array_rand($charactersArray)];

        // -----------------------------------------------------------------------

        // -----------------------------------------------------------------------
        // boss ------------------------------------------------------------------
        
        // convert persistentCollection of boss to array of entities (can be done with 'getValues()' aswell)
        $bossesArray = $challenge->getBosses()->toArray();
        // array_rand to get 1 entity randomized from new array
        $boss = $bossesArray[array_rand($bossesArray)];
        
        // -----------------------------------------------------------------------

        // -----------------------------------------------------------------------
        // restrictions ----------------------------------------------------------

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

        // -----------------------------------------------------------------------

        return [
            'character' => $character,
            'boss' => $boss,
            'restrictions' => $restrictions
        ];

        // ***********************************************************************************************************
        // ***********************************************************************************************************
    }
}
