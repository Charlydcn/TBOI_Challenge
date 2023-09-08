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

        if(count($formData) > 1) {
            foreach($formData as $key => $value) {

                // ---------------------------------------------------------------------------------
                // character (if string $key starts by 'ch_' (position === 0) it's a character)
                if (strpos($key, 'ch_') === 0) {
                    if($this->isValidInt($value) === true) {
                        // correct id
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
                        // correct id
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
                        // correct id
                        // add id to restrictions array
                        array_push($restrictionsIds, $value);
                    } else {
                        // incorrect id
                    }
                }
                // ---------------------------------------------------------------------------------

            }
            
            // character
            $characterId = $charactersIds[array_rand($charactersIds)];    
            $character = $characterRepository->findOneBy(['id' => $characterId]);

            // boss
            $bossId = $bossesIds[array_rand($bossesIds)];
            $boss = $bossRepository->findOneBy(['id' => $bossId]);

            // restrictions
            $restrictions = [];

            if(!empty($restrictionsIds) && count($restrictionsIds) <= 3) {
                foreach($restrictionsIds as $restrictionId) {
                    $restriction = $restrictionRepository->findBy(['id' => $restrictionId]);
                    array_push($restrictions, $restriction);
                }
            } else {
                
            }

        } else {
            $character = null;
            $boss = null;
            $restrictions = null;
        }


        return $this->render('challenge/index.html.twig', [
            'character' => $character,
            'boss' => $boss,
            'restrictions' => $restrictions,
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
