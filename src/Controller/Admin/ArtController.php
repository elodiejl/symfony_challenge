<?php

namespace App\Controller\Admin;

use App\Entity\Art;
use App\Form\ArtType;
use App\Repository\ArtRepository;
use App\Service\PictureService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/art', name:'admin_art_')]

class ArtController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ArtRepository $artRepository): Response
    {
        return $this->render('admin/art/index.html.twig', [
            'art' => $artRepository->findAll(),
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArtRepository $artRepository, PictureService $pictureService, SluggerInterface $slugger): Response
    {
        $art = new Art();
        $form = $this->createForm(ArtType::class, $art);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $picture = $form->get('imageFile')->getData();


            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);

                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture->guessExtension();


                // Move the file to the directory where brochures are stored
                try {
                    $picture->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );

                } catch (FileException $e) {
                    dd($e);
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $art->setImageFile($newFilename);
            }
            $artRepository->save($art, true);
            return $this->redirectToRoute('admin_art_index', [], Response::HTTP_SEE_OTHER);
            // ... persist the $product variable or any other work
        }

        return $this->render('admin/art/new.html.twig', [
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
