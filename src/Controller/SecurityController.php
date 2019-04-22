<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BookingRepository;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return Response
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        $userId = $this->getUser()->getId();
        if ($userId) {
            return $this->redirectToRoute('movies');
        }
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/me", name="profile")
     * @param SessionRepository $sessionRepository
     * @param BookingRepository $bookingRepository
     * @return Response
     */
    public function meController(SessionRepository $sessionRepository, BookingRepository $bookingRepository)
    {
        $user = $this->getUser();
        if (!$this->getUser()->getId()) {
            return $this->redirectToRoute('login');
        }
        $sessions = [];

        $booking = $bookingRepository->findBy(['user' => $user->getId()]);
        foreach ($booking as $booked) {
            $sessionsQuery = $sessionRepository->findBy(['id' => $booked->getSession()]);
            foreach ($sessionsQuery as $session) {
                $now = new \DateTime();
               // negative => not yet passed
                $sessions[$booked->getId()]['title'] = $session->getTitle();
                $sessions[$booked->getId()]['date'] = $session->getDate();
                $sessions[$booked->getId()]['movie'] = $session->getMovie()->getTitle();
                $sessions[$booked->getId()]['room_title'] = $session->getRoom()->getName();
                $sessions[$booked->getId()]['room_number'] = $session->getRoom()->getNumber();
                $sessions[$booked->getId()]['places'] = $booked->getPlaces();
                $sessions[$booked->getId()]['book_id'] = $booked->getId();
                // session not yet passed
                if ($now < $session->getDate()) {
                    $sessions[$booked->getId()]['seen'] = false;
                } else {
                    $sessions[$booked->getId()]['seen'] = true;
                }
            }
        }
        return $this->render('security/profile.html.twig', array(
            'currentUser' => $user,
            'sessions' => $sessions
        ));
    }
}
