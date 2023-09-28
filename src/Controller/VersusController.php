<?php

namespace App\Controller;

use App\Entity\Versus;
use App\Form\VersusType;
use App\Entity\Challenge;
use App\Form\PlayVersusType;
use App\Repository\VersusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VersusController extends AbstractController
{
    #[Route('/versus', name: 'app_versus')]
    public function index(VersusRepository $versusRepository): Response
    {
        $versus = $versusRepository->findAll();

        return $this->render('versus/index.html.twig', [
            'versus' => $versus,
        ]);
    }

    #[Route('/versus/new/{id}', name: 'new_versus')]
    public function new(
        Versus $versus = null,
        Challenge $challenge,
        Request $request,
        Security $security,
        EntityManagerInterface $entityManager): Response
    {
        // verify that versus id in url parameter doesn't already exist
        if (!$versus) {
            $versus = new Versus();
        } else {
            // if versus already exist, redirect to show view (no edit for this entity)
            return $this->redirectToRoute('show_challenge', [
                'id' => $challenge->getId(),
            ]);
        }
        
        // create form from VersusType
        $form = $this->createForm(VersusType::class, $versus);

        // handle request
        $form->handleRequest($request);

        // if form submitted & valid
        if ($form->isSubmitted() && $form->isValid()) {

            // find current user with Security's method getUser()
            $user = $security->getUser();

            // hydrate $versus attributes with form data
            $versus = $form->getData();

            // set versus challenge to challenge from which the versus is getting created (challenge id passed in url parameter)
            $versus->setChallenge($challenge);

            // set user with current logged in user
            $versus->setCreator($user);

            $versus->setClosed(false);

            // if public isn't checked (so is null in form data, set it to false)
            if (!$versus->isPublic()) {
                $versus->setPublic(false);
            }

            $versus->setWinner($user);
            
            // persist = prepare PDO
            $entityManager->persist($versus);
            // flush = execute PDO
            $entityManager->flush();

            return $this->redirectToRoute('show_versus', [
                'id' => $versus->getId(),
            ]);
        }
        
        return $this->render('versus/new.html.twig', [
            'newVersusForm' => $form,
        ]);
    }

    #[Route('/versus/{id}', name: 'show_versus')]
    public function show(Versus $versus): Response
    {
        return $this->render('versus/show.html.twig', [
            'versus' => $versus,
        ]);
    }

    #[Route('/versus/play/{id}', name: 'play_versus')]
    public function play(
        Versus $versus,
        PlayVersus $playVersus = null,
        Security $security,
        Request $request,
        EntityManagerInterface $entityManager): Response
    {

        $playVersus = new PlayVersus;

        // EN COURS DE CREATION, REFLECHIR COMMENT PROCEDER QUAND ON 'JOUE' A UN VERSUS, IL FAUT MONTRER LE CHALLENGE POUR QUE
        // L'UTILISATEUR SACHE QUOI FAIRE
        // maquettage en cours

        // create form from VersusType
        $form = $this->createForm(PlayVersusType::class, $versus);

        // handle request
        $form->handleRequest($request);

        // if form submitted & valid
        if ($form->isSubmitted() && $form->isValid()) {

            
            
            // persist = prepare PDO
            $entityManager->persist($versus);
            // flush = execute PDO
            $entityManager->flush();

            return $this->redirectToRoute('show_versus', [
                'id' => $versus->getId(),
            ]);
        }
        
        return $this->render('versus/play.html.twig', [
            'newPlayVersusForm' => $form,
        ]);


    }
}
