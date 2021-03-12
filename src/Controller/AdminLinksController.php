<?php

namespace App\Controller;

use App\Entity\Links;
use App\Form\AdminLinksType;
use App\Repository\LinksRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminLinksController extends AbstractController
{
    /**
     * @Route("/admin/links", name="admin_links")
     */
    public function index(LinksRepository $linksRepository)
    {
        $link1 = $linksRepository->findByType(1);
        $link2 = $linksRepository->findBytype(2);

        return $this->render('admin/adminLinks.html.twig', [
            'game' => $link1,
            'video' => $link2,
        ]);
    }

    /**
     * @Route("/admin/links/add", name="admin_links_add")
     */
    public function LinkAdd(LinksRepository $linksRepository, Request $request)
    {
        $link = new Links();

        $form = $this->createForm(AdminLinksType::class, $link);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($link);
            $manager->flush();

            return $this->redirectToRoute('admin_links');

            $this->addFlash(
                'success',
                'Le lien à bien été ajouté'
            );
        }
        
        return $this->render('admin/adminAddLink.html.twig', [
           'formLink' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/links/update-{id}", name="admin_links_update")
     */
    public function linkUpdate(LinksRepository $linksRepository, Request $request, $id)
    {
        $link = $linksRepository->find($id);

        $form = $this->createForm(AdminLinksType::class, $link);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($link);
            $manager->flush();

            return $this->redirectToRoute('admin_links');

            $this->addFlash(
                'success',
                'Le lien à bien été modifié'
            );
        }

        return $this->render('admin/adminUpdateLink.html.twig', [
            'updateLink' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/links/delete-{id}", name="admin_links_delete")
     */
    public function linkDelete(LinksRepository $linksRepository, $id)
    {
        $link = $linksRepository->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($link);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le lien à bien été supprimé'
        );

        return $this->redirectToRoute('admin_links');
    }
}
