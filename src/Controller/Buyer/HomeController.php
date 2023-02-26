<?php

namespace App\Controller\Buyer;

use App\Repository\ArtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/buyer/home', name: 'app_buyer_home', methods: ['GET'])]
    public function index(ArtRepository $artRepository): Response
    {
        return $this->render('buyer/home/index.html.twig', [
            'art' => $artRepository->findAll(),
        ]);
    }

}
