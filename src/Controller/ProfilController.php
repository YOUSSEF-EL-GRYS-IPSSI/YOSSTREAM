<?php

namespace App\Controller;

use App\Form\ModifProfilType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil', methods: ['GET', 'POST'])]
    public function profil(): Response
    {

        return $this->render('profil/profil_user.html.twig', [
        ]);
    }

    #[Route('/profil/modifier/', name: 'modifier_profil', methods: ['GET', 'POST'])]
    public function modifier_profil(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ModifProfilType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Profil mis à jour');
            return $this->redirectToRoute('profil');

        }
        return $this->render('profil/modifier_profil.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
