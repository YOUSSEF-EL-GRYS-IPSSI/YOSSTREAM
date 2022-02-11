<?php

namespace App\Controller;

use App\Entity\Movies;
use App\Repository\MoviesRepository;
use App\Repository\SeriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'catalogue')]
    public function catalogue(MoviesRepository $movieRepository): Response
    {

        $movies = $movieRepository->findAll();

        // $series = $repoSeries->findAll();

        return $this->render('catalogue/catalogue.html.twig', [
            'movies' => $movies
            // 'series' => $series
        ]);
    }
    
    #[Route('/fiche_movies/{id}', name: 'fiche_movies', methods: ['GET', 'POST'])]
    public function fiche_serie(Movies $movies) : Response
    {


        return $this->render('catalogue/fiche_movies.html.twig' , [
          "movie" => $movies
          
        ]);
    }
}
