<?php

namespace App\Controller\Vendor;

use App\Entity\Art;
use App\Entity\User;
use App\Form\ArtType;
use App\Repository\ArtRepository;
use App\Repository\UserRepository;
use App\Service\PictureUpload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/vendor/art', name:'vendor_art_')]

class ArtVendorController extends AbstractController
{

    /**
     * @throws Exception
     */
    #[Route('/new/{id}', name: 'new', methods: ['GET', 'POST'])]
    public function new(User $user, Request $request, ArtRepository $artRepository, PictureUpload $pictureUpload): Response
    {
        $art = new Art();
        $form = $this->createForm(ArtType::class, $art);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('imageFile')->getData();

            $art->setVendor($user->getId());

            if ($picture) {
                $pictureFileName = $pictureUpload->upload($picture);
                $art->setImageFile($pictureFileName);
            }
            $artRepository->save($art, true);
            return $this->redirectToRoute('app_vendor_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vendor/art/new.html.twig', [
            'art' => $art,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Art $art): Response
    {
        return $this->render('admin/art/show.html.twig', [
            'art' => $art,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Art $art, ArtRepository $artRepository): Response
    {
        $form = $this->createForm(ArtType::class, $art);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artRepository->save($art, true);

            return $this->redirectToRoute('admin_art_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/art/edit.html.twig', [
            'art' => $art,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Art $art, ArtRepository $artRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$art->getId(), $request->request->get('_token'))) {
            $artRepository->remove($art, true);
        }

        return $this->redirectToRoute('admin_art_index', [], Response::HTTP_SEE_OTHER);
    }
}
