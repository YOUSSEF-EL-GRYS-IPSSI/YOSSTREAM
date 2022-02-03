<?php

namespace App\Controller;

use App\Entity\Movies;
use DateTimeImmutable;
use App\Form\MoviesType;
use App\Repository\MoviesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/movies')]
class MoviesController extends AbstractController
{
    #[Route('/afficher', name: 'movies_afficher', methods: ['GET'])]
    public function movies_afficher(MoviesRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();
        return $this->render('movies/movies_afficher.html.twig', [
            'movies' => $movies
        ]);
    }

    #[Route('/ajouter', name: 'movies_ajouter', methods: ['GET', 'POST'])]
    public function movies_ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $movies = new Movies();
        $form = $this->createForm(MoviesType::class, $movies);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movies->setDateAt(new \DateTimeImmutable('now'));
            $entityManager->persist($movies);
            $entityManager->flush();

            return $this->redirectToRoute('movies_afficher', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movies/movies_ajouter.html.twig', [
           'form' => $form->createView()
        ]);
    }

    

    #[Route('/{id}/modifier', name: 'movies_modifier', methods: ['GET', 'POST'])]
    public function movies_modifier(Request $request, Movies $movies, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MoviesType::class, $movies);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('movies_afficher', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movies/movies_modifier.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}', name: 'movies_supprimer', methods: ['POST'])]
    public function movies_supprimer(Request $request, Movies $movies, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('supprimer',$movies->getId(), $request->request->get('_token'))) {
            $entityManager->remove($movies);
            $entityManager->flush();
        }

        return $this->redirectToRoute('movies_afficher', [], Response::HTTP_SEE_OTHER);
    }
}
