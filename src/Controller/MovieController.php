<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 11/04/2019
 * Time: 16:10
 */

namespace App\Controller;
use App\Repository\MovieRepository;
use App\Entity\User;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;

class MovieController extends AbstractController
{
    /**
     * @Route("/movies", name="movies")
     * @param MovieRepository $movieRepository
     */
    public function listingMovies(MovieRepository $movieRepository) {
        $movies = $movieRepository->findAll();
        return  $this->render('movies.html.twig', array(
            'movies' => $movies
        ));
    }

    /**
     * @Route("/movies/{id}", name="movie")
     * @param $id
     * @param MovieRepository $movieRepository
     * @param SessionRepository $sessionRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayMovie(
        $id,
        MovieRepository $movieRepository,
        SessionRepository $sessionRepository,
        User $user
    ) {
        $movie = $movieRepository->findOneBy(['id' => $id]);
        $movieId = $movie->getId();
        $logged = $user->getUsername() ? 1 : 0;
        $sessions = $sessionRepository->findBy(['movie' => $movieId]);
        return  $this->render('movie.html.twig', array(
            'movie' => $movie,
            'sessions' => $sessions,
            'logged' => $logged
        ));
    }

}