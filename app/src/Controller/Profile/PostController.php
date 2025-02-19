<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Entity\Post;
use App\Entity\User;
use App\Form\AddPostFormType;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/profil/articles', name: 'app_profile_post_')]
final class PostController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    #[Route('/ajouter', name: 'add')]
    public function addArticle(
        Request $request,
        SluggerInterface $slugger,
        EntityManagerInterface $em,
        PictureService $pictureService,
    ): Response {
        $post = new Post();

        $form = $this->createForm(AddPostFormType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ** @var string $s */
            $s = $slugger->slug((string) $post->getTitle());
            $post->setSlug(strtolower((string) $s));

            /** @var User $user */
            $user = $this->getUser();
            $post->setUser($user);

            $featuredImage = $form->get('featuredImage')->getData();

            // $post->setFeaturedImage('default.webp');
            /** @var UploadedFile $featuredImage */
            $image = $pictureService->square($featuredImage, 'articles', 300);

            $post->setFeaturedImage($image);

            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'L\'article a été créé');

            return $this->redirectToRoute('app_profile_post_index');
        }

        return $this->render('profile/post/add.html.twig', [
            'form' => $form,
        ]);
    }
}
