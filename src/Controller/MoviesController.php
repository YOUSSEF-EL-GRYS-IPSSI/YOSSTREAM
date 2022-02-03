<?php

namespace App\Controller;

use App\Entity\Movies;
use App\Form\MoviesType;
use App\Repository\MoviesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movies')]
class MoviesController extends AbstractController
{
    #[Route('/afficher', name: 'movies_afficher', methods: ['GET'])]
    public function movies_afficher(MoviesRepository $moviesRepository): Response
    {
        return $this->render('movies/afficher.html.twig', [
            'movies' => $moviesRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'movies_ajouter', methods: ['GET', 'POST'])]
    public function movies_ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $movie = new Movies();
        $form = $this->createForm(MoviesType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($movie);
            $entityManager->flush();

            return $this->redirectToRoute('movies_afficher', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('movies/afficher.html.twig', [
            'movies' => $movie,
            'form' => $form,
        ]);
    }

    

    #[Route('/{id}/modifier', name: 'movies_modifier', methods: ['GET', 'POST'])]
    public function movies_modifier(Request $request, Movies $movie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MoviesType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('movies_afficher', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('movies/modifier.html.twig', [
            'movies' => $movie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'movies_supprimer', methods: ['POST'])]
    public function movies_supprimer(Request $request, Movies $movie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('supprimer'.$movie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($movie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('movies_afficher', [], Response::HTTP_SEE_OTHER);
    }
}
