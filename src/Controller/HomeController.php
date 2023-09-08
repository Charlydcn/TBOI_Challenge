<?php

namespace App\Controller;

use App\Repository\BossRepository;
use App\Repository\CharacterRepository;
use App\Repository\RestrictionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(CharacterRepository $characterRepository, BossRepository $bossRepository, RestrictionRepository $restrictionRepository): Response
    {

        $characters = $characterRepository->findAll();
        $bosses = $bossRepository->findAll();
        $restrictions = $restrictionRepository->findAll();

        $character = null;
        $boss = null;
        $userRestrictions = null;

        return $this->render('home/index.html.twig', [
            'characters' => $characters,
            'bosses' => $bosses,
            'restrictions' => $restrictions,
            'character' => $character,
            'boss' => $boss,
            'userRestrictions' => $userRestrictions,
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
        $characters = [];
        $bosses = [];
        $restrictions = [];

        if(count($formData) > 1) {
            foreach($formData as $key => $value) {

                // ---------------------------------------------------------------------------------
                // character (if string $key starts by 'ch_' (position === 0) it's a character)
                if (strpos($key, 'ch_') === 0) {
                    if($this->isValidInt($value) === true) {
                        // correct id
                        // add id to characters array
                        array_push($characters, $value);
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
                        array_push($bosses, $value);
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
                        array_push($restrictions, $value);
                    } else {
                        // incorrect id
                    }
                }
                // ---------------------------------------------------------------------------------

            }
            
            // on randomise le tableau $characters pour obtenir un $characterId final
            $characterId = $characters[array_rand($characters)];
    
            // on trouve le personnage correspondant à l'id
            $character = $characterRepository->findOneBy(['id' => $characterId]);

            // pareil pour le boss
            $bossId = $bosses[array_rand($bosses)];
            $boss = $bossRepository->findOneBy(['id' => $bossId]);

            // restrictions in progress

            // $restrictionId = $restrictions[array_rand($restrictions)];
            // $restriction = $restrictionRepository->findOneBy(['id' => $restrictionId]);

        } else {
            $character = null;
            $boss = null;
            $restrictions = null;
        }

        $characters = $characterRepository->findAll();
        $bosses = $bossRepository->findAll();
        $restrictions = $restrictionRepository->findAll();


        return $this->render('home/index.html.twig', [
            'characters' => $characters,
            'bosses' => $bosses,
            'restrictions' => $restrictions,
            'character' => $character,
            'boss' => $boss,
            'restrictions' => $restrictions,
        ]);
    }

    function isValidInt($value)
    {
        // vérifier que c'est bien un string
        if (is_string($value)) {

            // supprimer tout ce qui n'est pas un chiffre
            $numericValue = preg_replace('/[^0-9]/', '', $value);

            // si c'est vide, c'est qu'il n'y avait aucun chiffre alors return false
            if(empty($numericValue)) {
                return false;
            } else {
                
                // vérifier si c'est un entier avec FILTER_VALIDATE_INT
                $intValue = filter_var($numericValue, FILTER_VALIDATE_INT);
                
                // vérifier que la valeur passe le filtre et que le $numericValue est de 10 caractères maximum 
                if ($intValue !== false && strlen($numericValue) <= 10) {
                    return true;
                }
            }
        }
        return false;
    }

}
