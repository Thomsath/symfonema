<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 11/04/2019
 * Time: 18:36
 */

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\User;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Repository\RoomRepository;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    /**
     * @Route("/book", name="book")
     * @param User $user
     * @param Request $request
     * @param BookingRepository $bookingRepository
     * @param SessionRepository $sessionRepository
     */
    public function mainAction(Request $request,
                               BookingRepository $bookingRepository,
                               SessionRepository $sessionRepository,
                                RoomRepository $roomRepository
    )
    {
        if(!$this->getUser()->getId()) {
            return $this->redirectToRoute('login');
        }
        $session = $sessionRepository->findBy(['id' => htmlspecialchars($_GET['sessionId'])])[0];
        $max_places = $sessionRepository->findRoomBySession($session)[0]->getRoom()->getMaxPlaces();
        $all_booking = $bookingRepository->findRemainingPlacesBySession($session);
        $taken_places = 0;
        foreach($all_booking as $booking) {
            $taken_places += $booking->getPlaces();
        }
        $err = false;
        if($taken_places === $max_places) {
            $err = "Plus aucune place de disponible pour cette séance";
        }
        $manager = $this->getDoctrine()->getManager();
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking,[]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // Number of taken places + number of places already taken > max number of places
            if($taken_places + $booking->getPlaces() > $max_places) {
                $err = "Nous ne pouvons vous délivrer" . $booking->getPlaces() . " places par manque de places pour cette séance.";
                if($taken_places + $booking->getPlaces() - $taken_places > 0) {
                    $err = "Nous ne pouvons vous délivrer" . $taken_places . "par manque de places pour cette séance.
                     Cependant, il resque " . ($max_places - $taken_places) . "places encore disponibles";
                }
            }
            if($taken_places + $booking->getPlaces() <= $max_places) {
                $booking->setSession($session);
                $booking->setUser($this->getUser());
                $manager->persist($booking);
                $manager->flush();
                return $this->redirectToRoute('homepage');
            }
        }
        return $this->render('book.html.twig', array(
            'form' => $form->createView(),
            'err' => $err,
            'taken_places' => $taken_places,
            'max_places' => $max_places,
            'remaining_places' => $max_places - $taken_places
        ));
    }
    /**
     * @Route("/book/delete/{id}", name="delete_book")
     * @param User $user
     * @param Request $request
     * @param BookingRepository $bookingRepository
     * @param SessionRepository $sessionRepository
     */
    public function deleteAction($id, Request $request, BookingRepository $bookingRepository)
    {
        $bookingRepository->deleteBookingById($id);
        return $this->redirectToRoute('profile');
    }
}