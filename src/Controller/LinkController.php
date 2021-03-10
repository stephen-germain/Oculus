<?php

namespace App\Controller;

use App\Repository\LinksRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LinkController extends AbstractController
{
    /**
     * @Route("/link", name="link")
     */
    public function index(LinksRepository $linksRepository)
    {
        $link1 = $linksRepository->findByType(1);
        $link2 = $linksRepository->findByType(2);


        return $this->render('link/links.html.twig', [
            'game' => $link1,
            'video' => $link2,
        ]);
    }
}
