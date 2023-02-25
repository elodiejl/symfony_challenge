<?php

namespace App\Controller\Admin;

use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(OrderRepository $orderRepository, UserRepository $userRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $order = $orderRepository->findAll();
        $ordermensuel = $orderRepository->findByMonth();
        $gainsAnnuels = 0;
        $gainsMensuels = 0;
        $accountsToValidate = $userRepository->findBy(['expectation'=>true]);
        foreach ($order as $o) $gainsAnnuels += $o->getTotalPrice();

        foreach ($ordermensuel as $om) $gainsMensuels += $om->getTotalPrice();

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('admin/index.html.twig', [
            'gainsAnnuels' => $gainsAnnuels,
            'gainsMensuels' => $gainsMensuels,
            'toValidate' => count($accountsToValidate),
            'chart' => $chart
        ]);
    }
}
