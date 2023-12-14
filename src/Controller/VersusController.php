<?php

namespace App\Controller;

use DateTime;
use App\Entity\Versus;
use App\Form\VersusType;
use App\Entity\Challenge;
use App\Form\PlayVersusType;
use App\Repository\VersusRepository;
use App\Repository\PlayVersusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VersusController extends AbstractController
{
    #[Route('/versus', name: 'app_versus')]
    public function index(VersusRepository $versusRepository, Security $security): Response
    {
        $user = $security->getUser();

        if(!$user) {
            $this->addFlash('error', 'You have to be logged in to play Versus !');

            return $this->redirectToRoute('app_home');
        }

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
        // find current user with Security's method getUser()
        $user = $security->getUser();

        if($user) {

            $versus = new Versus();
            
            // create form from VersusType
            $form = $this->createForm(VersusType::class, $versus);
    
            // handle request
            $form->handleRequest($request);
    
            // if form submitted & valid
            if ($form->isSubmitted() && $form->isValid()) {

                // hydrate $versus attributes with form data
                $versus = $form->getData();

                $now = new DateTime;

                // if versus' end date isn't prior to today's date, redirect (it's already been prevented client-side with js, but extra verification)
                if($versus->getEndDate() && $versus->getEndDate() < $now) {
                    $this->addFlash('error', 'Incorrect end date');
                    
                    return $this->redirectToRoute('new_versus', ['id' => $challenge->getId()]);
                }

                // set versus challenge to challenge from which the versus is getting created (challenge id passed in url parameter)
                $versus->setChallenge($challenge);
    
                // set user with current logged in user
                $versus->setCreator($user);

                $versus->setClosed(false);
    
                // if public isn't checked (so is null in form data, set it to false)
                if (!$versus->isPublic()) {
                    $versus->setPublic(false);
                }
                
                // persist = prepare PDO
                $entityManager->persist($versus);
                // flush = execute PDO
                $entityManager->flush();
    
                return $this->redirectToRoute('show_versus', [
                    'id' => $versus->getId(),
                ]);
            }
        } else {
            return $this->redirectToRoute('show_challenge', [
                'id' => $challenge->getId(),
            ]);
        }

        
        return $this->render('versus/new.html.twig', [
            'newVersusForm' => $form,
            'challenge' => $challenge,
        ]);
    }

    #[Route('/versus/{id}', name: 'show_versus')]
    public function show(
        Versus $versus = null,
        Security $security,
        PlayVersusRepository $playVersusRepository): Response
    {

        $user = $security->getUser();

        if(!$user) {
            $this->addFlash('error', 'You have to be logged in to play Versus !');

            return $this->redirectToRoute('app_home');
        }

        if (!$versus) {
            $this->addFlash('error', 'This versus doesn\'t exist (error #00004)');

            return $this->redirectToRoute('app_home');
        }

        $winners = $playVersusRepository->findBy(['versus' => $versus->getId(), 'completed' => true]);
        $bestRuns = $playVersusRepository->findBestRuns($versus->getId(), 10);

        return $this->render('versus/show.html.twig', [
            'versus' => $versus,
            'bestRuns' => $bestRuns,
        ]);
    }

    #[Route('/challenge/{id}/versus', name: 'show_challenge_versus')]
    public function showChallengeVersus(
        Challenge $challenge,
        VersusRepository $versusRepository)
    {
        $versus = $versusRepository->findBy(['challenge' => $challenge, 'closed' => false]);

        return $this->render('challenge/show_challenge_versus.html.twig', [
            'versus' => $versus,
            'challenge' => $challenge,
        ]);
    }

    #[Route('/versus/{id}/delete', name: 'delete_versus')]
    public function deleteVersus(
        Versus $versus,
        Security $security,
        EntityManagerInterface $em): Response
    {
        if($versus) {
            $user = $security->getUser();

            if($versus->getCreator() === $user || $security->isGranted('ROLE_ADMIN', $user)) {
                $em->remove($versus);
                $em->flush();
        
                $this->addFlash('success', 'Versus deleted successfully');
                
                return $this->redirectToRoute('app_home');
        } else {
            $this->addFlash('error', 'You can\'t delete a Versus if you\'re not the creator or an administrator');

            return $this->redirectToRoute('show_versus', [
                'id' => $versus->getId(),
            ]);
            }
    
        } else {
            $this->addFlash('error', 'This versus doesn\'t exist (error #00001)');

            return $this->redirectToRoute('app_home');
        }
    }
    
}
