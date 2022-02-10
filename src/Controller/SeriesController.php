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

#[Route('admin/series')]
class SeriesController extends AbstractController
{
    #[Route('/afficher', name: 'series_afficher', methods: ['GET'])]
    public function series_afficher(SeriesRepository $seriesRepository): Response
    {
        $series = $seriesRepository->findAll();
        
        return $this->render('series/series_afficher.html.twig', [
            'series' => $series
        ]);
    }

    #[Route('/ajouter', name: 'series_ajouter', methods: ['GET', 'POST'])]
    public function series_ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $series = new Series();

        $form = $this->createForm(SeriesType::class, $series,  ['ajouter' => true]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $imageFile = $form->get('image')->getData();
            $videoFile = $form->get('video')->getData();

            // S'il y a upload imageFile est un objet
            // Sinon imageFile = null

            if($imageFile) // Si un fichier a été upload
            {
                // Renommer l'image
                // $nameImage = date("YmdHis") . "-" . uniqid() . "-" . rand(100000, 999999) . "-" .
                // $imageFile->getClientOriginalName();

                $nameImage = date("YmdHis") . "-" . uniqid() . "-" . rand(100000, 999999) . "." . $imageFile->getClientOriginalExtension();

                // Déplacer le fichier (image) dans le projet

                $imageFile->move(
                    $this->getParameter("imageUpload"),
                    $nameImage
                );

              

                // Enregistrer le nom de l'image en bdd
                $series->setImage($nameImage);
    

            }

            if($videoFile)
            {
                $nameVideo = date("YmdHis") . "-" . uniqid() . "-" . rand(100000, 999999) . "." . $videoFile->getClientOriginalExtension();

                $videoFile->move(
                    $this->getParameter("videoUpload"),
                    $nameVideo
                );

                $series->setVideo($nameVideo);
            }
            
            //dd($series);

            
            //dd($series);

            //dump($produit); 2ème étape de mes données
            $series->setDateAt(new \DateTimeImmutable("now"));

            $entityManager->persist($series);

            $entityManager->flush();

            $this->addFlash("success", "Le produit " . $series->getTitle() . " a bien été ajoutée");

            return $this->redirectToRoute('series_afficher', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('series/series_ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/modifier/{id}', name: 'series_modifier', methods: ['GET', 'POST'])]
    public function series_modifier(Request $request, Series $series, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SeriesType::class, $series, ['modifier' => true]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $imageFile = $form->get('imageFile')->getData();
            $videoFile = $form->get('videoFile')->getData();

            // S'il y a upload imageFile est un objet
            // Sinon imageFile = null

            if($imageFile) // Si un fichier a été upload
            {
                // Renommer l'image
                // $nameImage = date("YmdHis") . "-" . uniqid() . "-" . rand(100000, 999999) . "-" .
                // $imageFile->getClientOriginalName();

                $nameImage = date("YmdHis") . "-" . uniqid() . "-" . rand(100000, 999999) . "." . $imageFile->getClientOriginalExtension();

                // Déplacer le fichier (image) dans le projet;


                $imageFile->move(
                    $this->getParameter("imageUpload"),
                    $nameImage
                );

                // Enregistrer le nom de l'image en bdd

                $series->setImage($nameImage);
                



            }

            if($videoFile)
            {
                $nameVideo = date("YmdHis") . "-" . uniqid() . "-" . rand(100000, 999999) . "." . $videoFile->getClientOriginalExtension();

                $videoFile->move(
                    $this->getParameter("videoUpload"),
                    $nameVideo
                );

                $series->setVideo($nameVideo);
            }
            $series->setDateAt(new \DateTimeImmutable("now"));
            $entityManager->persist($series);

            $entityManager->flush();

            $this->addFlash("success", "La série " . $series->getTitle() . " a bien été modifiée");

            return $this->redirectToRoute('series_afficher', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('series/series_modifier.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/supprimer/{id}', name: 'series_supprimer', methods: ['GET', 'POST'])]
    public function series_supprimer(Series $series, EntityManagerInterface $entityManager): Response
    {
            $seriesTitle = $series->getTitle();
            $entityManager->remove($series);
            $entityManager->flush();
        
            $this->addFlash("success", "La série $seriesTitle a bien été supprimée");

        return $this->redirectToRoute('series_afficher');
    }
}
