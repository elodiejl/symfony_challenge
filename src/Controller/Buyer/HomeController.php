<?php

namespace App\Controller\Buyer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/buyer/home', name: 'app_buyer_home')]
    public function index(): Response
    {
        return $this->render('buyer/home/index.html.twig', [
        ]);
    }
}
