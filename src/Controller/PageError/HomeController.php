<?php

namespace App\Controller\PageError;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/pageError', name: 'app_pageError')]
    public function index(): Response
    {
        return $this->render('pageError/index.html.twig', [
        ]);
    }
}
