<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VersusController extends AbstractController
{
    #[Route('/versus', name: 'app_versus')]
    public function index(): Response
    {
        return $this->render('versus/index.html.twig', [
            'controller_name' => 'VersusController',
        ]);
    }
}
