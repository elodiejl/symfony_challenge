<?php

namespace App\Controller\Buyer;

use App\Repository\ArtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeVendorController extends AbstractController
{
    #[Route('/vendor/home', name: 'app_vendor_home', methods: ['GET'])]
    public function index(ArtRepository $artRepository): Response
    {
        return $this->render('vendor/home/index.html.twig', [
            'art' => $artRepository->findAll(),
        ]);
    }

}
