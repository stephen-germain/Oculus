<?php

namespace App\Controller;

use App\Form\EditProfilFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/user/profil_upadate", name="profil_update")
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
}
