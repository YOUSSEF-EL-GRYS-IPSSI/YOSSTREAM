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

#[Route('admin/movies')]
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
        
        $form = $this->createForm(MoviesType::class, $movies, ['ajouter' => true ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
         {

            $imageFile = $form->get('image')->getData();
   
            if($imageFile)
            {
                $nameImage = date("YmdHis") . "-" . uniqid() . "-" . rand(100000, 999999) . "." . $imageFile->getClientOriginalExtension();
    
                $imageFile->move(
                    $this->getParameter("imageUpload"),
                    $nameImage
                );

                $movies->setImage($nameImage);


            }
            
            
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
        
        $form = $this->createForm(MoviesType::class, $movies, [ 'modifier' => true ]);
        $form->handleRequest($request);

      
        if ($form->isSubmitted() && $form->isValid()) {
          
            $imageFile = $form->get('imageFile')->getData();
   
          
            if($imageFile)
            {
                $nameImage = date("YmdHis") . "-" . uniqid() . "-" . rand(100000, 999999) . "." . $imageFile->getClientOriginalExtension();
    
                $imageFile->move(
                    $this->getParameter("imageUpload"),
                    $nameImage
                );

                $movies->setImage($nameImage);


            }
            
            
            $movies->setDateAt(new \DateTimeImmutable('now'));
            $entityManager->persist($movies);
            $entityManager->flush();

            

            return $this->redirectToRoute('movies_afficher', [], Response::HTTP_SEE_OTHER);


        }

        return $this->render('movies/movies_modifier.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/supprimer/{id}', name: 'movies_supprimer', methods: ['GET','POST'])]
    public function movies_supprimer( Movies $movies, EntityManagerInterface $entityManager): Response
    {
         
            $entityManager->remove($movies);
            $entityManager->flush();
        

        return $this->redirectToRoute('movies_afficher');



        
    }

    
    
}
