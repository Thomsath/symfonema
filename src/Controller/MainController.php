<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 11/04/2019
 * Time: 15:39
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function mainAction(Request $request)
    {
        return $this->render('security/index.html.twig', array(
            'controller_name' => 'l'
        ));
    }
}