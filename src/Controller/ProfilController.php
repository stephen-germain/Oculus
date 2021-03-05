<?php

namespace App\Controller;

use App\Form\ResetPasswordType;
use App\Form\EditProfilFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilController extends AbstractController
{
    /**
     * @Route("/user/profil", name="profil")
     */
    public function index(): Response
    {
        return $this->render('user_space/profil.html.twig');
    }

    /**
     * @Route("/user/profil/upadate", name="profil_update")
     */
    public function profilUpdate(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfilFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $data = $form->getData();
                // échapper les caractères spéciaux 
                $user->setName(strip_tags($data->getName()));

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Le profil à été modifiée'
                );
            }
            else{
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }

            return $this->redirectToRoute('profil');
        }


        return $this->render('user_space/profilEdit.html.twig', [
            'formUser' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/profil/resetPassword", name="profil_resetPassword")
     */
    public function profilResetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $resetPass = $this->getUser();
        $form = $this->createForm(ResetPasswordType::class, $resetPass);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($request->request->get('first_options') == $request->request->get('second_options')){
                $resetPass->setPassword(
                    $passwordEncoder->encodePassword(
                        $resetPass, $form->get('password')->getData()
                    )
                );

                $manager = $this->getDoctrine()->getManager();
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Votre mot de passe à bien été modifié'
                );

                return $this->redirectToRoute('profil');
                
            }
            else{
                $this->addFlash(
                    'danger',
                    'Les deux mots de passe ne sont pas identique'
                );
            }
        }

        return $this->render('user_space/profilResetPassword.html.twig', [
            'formResetPass' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/profil/delete", name="profil_delete")
     */
    public function profilDelete()
    {
        $user = $this->getUser();
        $this->container->get('security.token_storage')->setToken(null);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($user);
        $manager->flush();

        return $this->render('user_space/profilDelete.html.twig');
    }
}
