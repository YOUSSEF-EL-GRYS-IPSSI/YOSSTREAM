<?php

namespace App\Controller;

use App\Form\ModifMdpType;
use App\Form\ModifProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil_user', methods: ['GET', 'POST'])]
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

            $this->addFlash('success', 'Le profila été mis à jour');
            return $this->redirectToRoute('profil_user');

        }
        return $this->render('profil/modifier_profil.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profil/modifier/mdp', name: 'modifier_mdp', methods: ['GET', 'POST'])]
    public function modifier_mdp(Request $request, UserPasswordHasherInterface $passwordhash, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ModifMdpType::class, $user); 

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $old_password = $form->get('plainPassword')->getData();

            if($passwordhash->isPasswordValid($user, $old_password))
            {
                $new_password = $form->get('newplainPassword')->getData();
                $password = $passwordhash->hashPassword($user, $new_password);
                
                $user->setPassword($password);
                

            // $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Le mot de passe a été mis à jour');
            return $this->redirectToRoute('profil_user');
            }
        }
       
        return $this->render('profil/modifier_mdp.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
