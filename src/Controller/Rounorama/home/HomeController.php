<?php

namespace App\Controller\Rounorama\home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/rounorama/home', name: 'app_rounorama_home')]
    public function index(): Response
    {
        return $this->render('rounorama/home/index.html.twig', [
        ]);
    }
}
