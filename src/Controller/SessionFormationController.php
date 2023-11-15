<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SessionFormation;
use App\Repository\DemandeRepository;

use Doctrine\Persistence\ManagerRegistry;

class SessionFormationController extends AbstractController
{
    #[Route('/session/formationmois', name: 'app_session_formation')]
    public function formationMois(ManagerRegistry $doctrine): Response
    {        
        // $leMois = date('m');
        // $entityManager = $doctrine->getManager();

        // $sessions = $entityManager->getRepository('App\Entity\SessionFormation')
        //     ->createQueryBuilder('s')
        //     ->where("FORMAT(s.date_debut, 'MM') = :leMois")
        //     ->setParameter('leMois', $leMois)
        //     ->getQuery()
        //     ->getResult();

        // return $this->render('session_formation/index.html.twig', [
        //     'controller_name' => $sessions,
        // ]);
        $currentMonth = date('m');        
        $entityManager = $doctrine->getManager();

        $allSessions = $entityManager->getRepository('App\Entity\SessionFormation')->findAll();

        $lesSessions = array_filter($allSessions, function ($session) use ($currentMonth) {
            return $session->getDateDebut()->format('m') == $currentMonth;
        });

		return $this->render('session_formation/index.html.twig', Array('lesSessions' => $lesSessions));
    }
}
