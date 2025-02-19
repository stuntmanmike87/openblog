<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/articles', name: 'app_post_')]
final class PostController extends AbstractController
{
    #[Route(path: '', name: 'index')]
    public function index(PostRepository $postRepository, Request $request): Response
    {
        // On récupère le numéro de page
        $page = $request->query->get('page', strval(1));
        $data = $postRepository->getAllPaginated((int) $page, 2);

        return $this->render('post/index.html.twig', compact('data'));
    }

    #[Route(path: '/details/{slug}', name: 'details')]
    public function details(mixed $slug, PostRepository $postRepository): Response
    {
        $post = $postRepository->findOneBy(['slug' => $slug]);

        // Si le post n'existe pas
        if (!$post) {
            throw $this->createNotFoundException('Cet article n\'existe pas');
        }

        // Ici l'article existe, on l'envoie à la vue
        return $this->render('post/details.html.twig', compact('post'));
    }
}
