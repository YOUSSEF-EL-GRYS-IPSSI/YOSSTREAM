<?php

namespace App\Controller;

use App\Entity\Series;
use App\Form\SeriesType;
use App\Repository\SeriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/series')]
class SeriesController extends AbstractController
{
    #[Route('/afficher', name: 'series_afficher', methods: ['GET'])]
    public function series_afficher(SeriesRepository $seriesRepository): Response
    {
        return $this->render('series/afficher.html.twig', [
            'series' => $seriesRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'series_ajouter', methods: ['GET', 'POST'])]
    public function series_ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $series = new Series();
        $form = $this->createForm(SeriesType::class, $series);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($series);
            $entityManager->flush();

            return $this->redirectToRoute('series_afficher', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('series/afficher.html.twig', [
            'series' => $series,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/modifier', name: 'series_modifier', methods: ['GET', 'POST'])]
    public function series_modifier(Request $request, Series $series, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SeriesType::class, $series);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('series_afficher', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('series/modifier.html.twig', [
            'series' => $series,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'series_supprimer', methods: ['POST'])]
    public function series_supprimer(Request $request, Series $series, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('supprimer'.$series->getId(), $request->request->get('_token'))) {
            $entityManager->remove($series);
            $entityManager->flush();
        }

        return $this->redirectToRoute('series_afficher', [], Response::HTTP_SEE_OTHER);
    }
}
