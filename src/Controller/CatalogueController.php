<?php

namespace App\Controller;

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
    
}
