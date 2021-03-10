<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminLinksController extends AbstractController
{
    /**
     * @Route("/admin/links", name="admin_links")
     */
    public function index(): Response
    {
        return $this->render('admin/adminLinks.html.twig', [
            'controller_name' => 'AdminLinksController',
        ]);
    }
}
