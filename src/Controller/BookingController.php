<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 11/04/2019
 * Time: 18:36
 */

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    /**
     * @Route("/book", name="book")
     * @param Request $request
     * @param BookingRepository $bookingRepository
     */
    public function mainAction(Request $request, BookingRepository $bookingRepository)
    {
        $date =
//        var_dump($bookingRepository->findByDate());
        die;

//        $form = $this->createForm(UserType::class, $user,[
//            'validation_groups' => array('User', 'registration'),
//        ]);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//
//        }
    }
}