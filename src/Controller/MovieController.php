<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 11/04/2019
 * Time: 16:10
 */

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Entity\User;
use App\Repository\SessionRepository;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;

class MovieController extends AbstractController
{
    /**
     * @Route("/movies", name="movies")
     * @param Request $request
     * @param MovieRepository $movieRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listingMovies(Request $request, MovieRepository $movieRepository)
    {
        $movies = $movieRepository->findAll();
        $sch_movies = null;
        $err = null;
        $username = null;
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        if ($this->getUser()->getId()) {
            $username = $this->getUser()->getUsername();
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $sch_movies = $movieRepository->findUsage($form->getData());
            if (sizeof($sch_movies) === 0) {
                $err = "Aucun film n'a pu être trouvé concernant votre critère de recherche '" . $form->getData() . "'.";
            }
        }
        return $this->render('movies.html.twig', array(
            'movies' => $movies,
            'form' => $form->createView(),
            'sch_movies' => $sch_movies,
            'err' => $err,
            'username' => $username
        ));
    }

    /**
     * @Route("/movies/{id}", name="movie")
     * @param $id
     * @param MovieRepository $movieRepository
     * @param SessionRepository $sessionRepository
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayMovie(
        $id,
        MovieRepository $movieRepository,
        SessionRepository $sessionRepository
    )
    {
        $movie = $movieRepository->findOneBy(['id' => $id]);
        $movieId = $movie->getId();
        $err = null;
        $logged = $this->getUser()->getUsername() ? 1 : 0;
        $sessions = $sessionRepository->findByDate(new \DateTime(), $movieId);
        if (sizeof($sessions) === 0) {
            $err = "Aucune session n'a été trouvée pour le moment.";
        }
        return $this->render('movie.html.twig', array(
            'movie' => $movie,
            'sessions' => $sessions,
            'err' => $err,
            'logged' => $logged,
            'userId' => $this->getUser()->getId()
        ));
    }

}