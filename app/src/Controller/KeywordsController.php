<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Keywords;
use App\Form\KeywordsType;
use App\Repository\KeywordsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/keywords')]
final class KeywordsController extends AbstractController
{
    #[Route('/', name: 'app_keywords_index', methods: ['GET'])]
    public function index(KeywordsRepository $keywordsRepository): Response
    {
        return $this->render('keywords/index.html.twig', [
            'keywords' => $keywordsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_keywords_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $keyword = new Keywords();
        $form = $this->createForm(KeywordsType::class, $keyword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($keyword);
            $entityManager->flush();

            return $this->redirectToRoute('app_keywords_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('keywords/new.html.twig', [
            'keyword' => $keyword,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_keywords_show', methods: ['GET'])]
    public function show(Keywords $keyword): Response
    {
        return $this->render('keywords/show.html.twig', [
            'keyword' => $keyword,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_keywords_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Keywords $keyword, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(KeywordsType::class, $keyword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_keywords_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('keywords/edit.html.twig', [
            'keyword' => $keyword,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_keywords_delete', methods: ['POST'])]
    public function delete(Request $request, Keywords $keyword, EntityManagerInterface $entityManager): Response
    {
        /** @var string|null $token */
        $token = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete'.$keyword->getId(), $token)) {
            $entityManager->remove($keyword);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_keywords_index', [], Response::HTTP_SEE_OTHER);
    }
}
