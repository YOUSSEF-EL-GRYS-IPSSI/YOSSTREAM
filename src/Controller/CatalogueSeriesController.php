<?php

namespace App\Controller;

use App\Entity\Series;
use App\Repository\SeriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatalogueSeriesController extends AbstractController
{
    #[Route('/catalogue/series', name: 'catalogue_series')]
    public function index(SeriesRepository $repoSeries): Response
    {

        $series = $repoSeries->findAll();

        return $this->render('catalogue_series/catalogue_series.html.twig', [
            'series' => $series
        ]);
    }

    #[Route('/fiche_serie/{id}', name: 'fiche_serie', methods: ['GET', 'POST'])]
    public function fiche_serie(Series $series) : Response
    {


        return $this->render('catalogue_series/fiche_serie.html.twig' , [
          "serie" => $series
          
        ]);
    }

}
