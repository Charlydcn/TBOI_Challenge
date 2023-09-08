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
    #[Route('/', name: 'app_home')]
    public function index(CharacterRepository $characterRepository, BossRepository $bossRepository, RestrictionRepository $restrictionRepository): Response
    {

        $characters = $characterRepository->findAll();
        $bosses = $bossRepository->findAll();
        $restrictions = $restrictionRepository->findAll();

        return $this->render('home/index.html.twig', [
            'characters' => $characters,
            'bosses' => $bosses,
            'restrictions' => $restrictions,
        ]);
    }
}
