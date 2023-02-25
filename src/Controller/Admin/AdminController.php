<?php

namespace App\Controller\Admin;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findAll();
        $gainsAnnuels = 0;
        foreach ($order as $o){
            $gainsAnnuels += $o->getTotalPrice();
        }


        return $this->render('admin/index.html.twig', [
            'gainsAnnuels' => $gainsAnnuels,
        ]);
    }
}
