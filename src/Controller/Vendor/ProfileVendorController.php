<?php

namespace App\Controller\Vendor;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/vendor/', name:'app_vendor_')]

class ProfileVendorController extends AbstractController
{
    #[Route('profile', requirements: ['id' => '\d+'], name: 'profile', methods: ['GET'])]
    public function index(): Response
    {

        return $this->render('vendor/profile/show.html.twig', [
            'user' => $this->getUser(),

        ]);

    }

    #[Route('edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($this->getUser(), true);

            return $this->redirectToRoute('app_vendor_profile');
        }

        return $this->render('/vendor/profile/edit.html.twig', [
            'user' => $this->getUser(),
            'form' => $form,
        ]);
    }




}
