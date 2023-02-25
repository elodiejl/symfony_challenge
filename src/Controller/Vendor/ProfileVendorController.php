<?php

namespace App\Controller\Buyer;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/buyer/', name:'app_buyer_')]

class ProfileVendorController extends AbstractController
{
    #[Route('profile/{id}', name: 'profile', methods: ['GET'])]
    public function index(User $user): Response
    {
        $hashId = sha1($user->getId());

        return $this->render('buyer/profile/show.html.twig', [
            'user' => $user,

        ]);

    }

    #[Route('{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_buyer_profile', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('/buyer/profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('{id}/vendor', name: 'vendor', methods: ['GET', 'POST'])]
    public function becomeVendor(Request $request, User $user, UserRepository $userRepository): Response
    {
         $user->setExpectation(true);

            $userRepository->save($user, true);


        return $this->render('/buyer/profile/show.html.twig', [
            'user' => $user
        ]);
    }


}
