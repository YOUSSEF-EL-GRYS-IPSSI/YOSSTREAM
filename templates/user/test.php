<?php
/**
     * @Route("/password_edit", name="password_edit")
     */

    public function modificationPassword(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface, EntityManagerInterface $manager, UserRepository $repoUser) 
    {

        $user = $repoUser->find($this->getUser());
 

        $passwordUpdate = new PasswordUpdate();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $acces = true;

           if( $passwordUpdate->getOldPassword() )
           {
                if(!password_verify($passwordUpdate->getOldPassword(), $user->getPassword()))
                {
                    $acces = false;
                    $form->get('oldPassword')->addError(new FormError("Incorrect Password"));
                } 
                else
                {
                    if(!$passwordUpdate->getPassword() OR !$passwordUpdate->getConfirmPassword())
                    {
                        $acces = false;
                        $form->get('password')->addError(new FormError("Enter New Password"));
                    }
                    else
                    {
                        if($passwordUpdate->getPassword() != $passwordUpdate->getConfirmPassword())
                        {
                            $acces = false;
                            $form->get('password')->addError(new FormError("The passwords are not the same"));
                        }
                        else
                        {
                            if(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$/' , $passwordUpdate->getPassword()))
                            {
                                
                                $acces = false;
                                $form->get('password')->addError(new FormError("Entre 8 et 15, 1 maj 1 min 1 chiffre et $ @ % * + - _ !  "));

            
                            }
                           
                        }
                    }
                    
                }
           }
           else
           {
               $acces = false;
               $form->get('oldPassword')->addError(new FormError("Enter Your current Password"));
           }
            





            if($acces)
            {
                $newPassword = $passwordUpdate->getPassword();
                $user->setPassword(
                    $userPasswordHasherInterface->hashPassword(
                            $user,
                            $newPassword
                        )
                    );
                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success', "Your password changed" );

                return $this->redirectToRoute('profil_fiche');
            }


        }


        return $this->render('user/password_modification.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }