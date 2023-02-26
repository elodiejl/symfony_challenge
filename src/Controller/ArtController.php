<?php

namespace App\Controller;

use App\Entity\Art;
use App\Entity\Comments;
use App\Form\ArtType;
use App\Form\CommentsType;
use App\Repository\ArtRepository;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/art')]
class ArtController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager,)
    {

    }
    #[Route('/', name: 'app_art_index', methods: ['GET'])]
    public function index(ArtRepository $artRepository): Response
    {
        return $this->render('art/index.html.twig', [
            'art' => $artRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_art_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArtRepository $artRepository): Response
    {
        $art = new Art();

        $this->denyAccessUnlessGranted('ART_NEW', $art);

        $form = $this->createForm(ArtType::class, $art);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artRepository->save($art, true);

            return $this->redirectToRoute('app_art_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('art/new.html.twig', [
            'art' => $art,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_art_show', methods: ['GET', 'POST'])]
    public function show(Art $art, Request $request, CommentsRepository $commentsRepository): Response
    {
        $comments = $commentsRepository->findBy(['art'=>$art->getId()]);
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setArt($art);
            $commentsRepository->save($comment,true);

            return $this->redirectToRoute('app_art_show', ['id' => $art->getId()]);
        }

        return $this->render('art/show.html.twig', [
            'art' => $art,
            'comments' => $comments,
            'comment_form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_art_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Art $art, ArtRepository $artRepository): Response
    {
        $this->denyAccessUnlessGranted('ART_EDIT', $art);
        $form = $this->createForm(ArtType::class, $art);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artRepository->save($art, true);

            return $this->redirectToRoute('app_art_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('art/edit.html.twig', [
            'art' => $art,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_art_delete', methods: ['POST'])]
    public function delete(Request $request, Art $art, ArtRepository $artRepository): Response
    {
        $this->denyAccessUnlessGranted('ART_DELETE', $art);
        if ($this->isCsrfTokenValid('delete'.$art->getId(), $request->request->get('_token'))) {
            $artRepository->remove($art, true);
        }

        return $this->redirectToRoute('app_art_index', [], Response::HTTP_SEE_OTHER);
    }
}
