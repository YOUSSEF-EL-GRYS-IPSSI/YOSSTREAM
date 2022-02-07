<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/genre')]

class GenreController extends AbstractController
{
    #[Route('/afficher', name: 'genre_afficher', methods: ['GET'])]
    public function genre_afficher(GenreRepository $genreRepository): Response
    {
        // On génère une exception
        throw $this->createNotFoundException('Page perdue');

        $genre = $genreRepository->findAll();

        return $this->render('genre/genre_afficher.html.twig', [
            'genre' => $genre
        ]);
    }

    #[Route('/ajouter', name: 'genre_ajouter', methods: ['GET', 'POST'])]
    public function genre_ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $genre = new Genre();

        $form = $this->createForm(GenreType::class, $genre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $entityManager->persist($genre);

            $entityManager->flush();

            $this->addFlash("success", "Le genre " . $genre->getType() . " a bien été ajouté");

            return $this->redirectToRoute('genre_afficher');
        }

        return $this->render('genre/genre_ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/modifier/{id}', name: 'genre_modifier', methods: ['GET', 'POST'])]
    public function genre_modifier(Request $request, Genre $genre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GenreType::class, $genre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($genre);

            $entityManager->flush();

            $this->addFlash("success", "Le genre " . $genre->getType() . " a bien été modifié");

            return $this->redirectToRoute('genre_afficher');
        }

        return $this->render('genre/genre_modifier.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/supprimer/{id}', name: 'genre_supprimer', methods: ['GET','POST'])]
    public function genre_supprimer(Genre $genre, EntityManagerInterface $entityManager): Response
    {
            $genreType = $genre->getType();
            $entityManager->remove($genre);
            $entityManager->flush();

            $this->addFlash("success", "Le genre $genreType a bien été supprimé");

        return $this->redirectToRoute('genre_afficher');
    }
}
