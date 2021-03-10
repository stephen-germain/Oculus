<?php

namespace App\Controller;

use App\Form\AdminUserFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        return $this->render('admin/adminUser.html.twig', [
            'users' => $users,
        ]);
    }

     /**
     * @Route("/admin/user/update-{id}", name="admin_user_update")
     */
    public function userUpdate(UserRepository $userRepository, Request $request, $id)
    {
        $users = $userRepository->find($id);

        $form = $this->createForm(AdminUserFormType::class, $users);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($users);
            $manager->flush();

            return $this->redirectToRoute('admin_user');

            $this->addFlash(
                'success',
                'Nouveau rôle affecté');
        }


        return $this->render('admin/adminUserUpdate.html.twig', [
            'adminUser' => $form->createView(),
        ]);
    }
}
