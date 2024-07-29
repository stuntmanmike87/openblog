<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Entity\Posts;
use App\Entity\Users;
use App\Form\AddPostFormType;
// use App\Repository\UsersRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/profil/articles', name: 'app_profile_posts_')]
final class PostsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/posts/index.html.twig', [
            'controller_name' => 'PostsController',
        ]);
    }

    #[Route('/ajouter', name: 'add')]
    public function addArticle(
        Request $request,
        SluggerInterface $slugger,
        EntityManagerInterface $em,
        // UsersRepository $usersRepository,
        PictureService $pictureService
    ): Response {
        $post = new Posts();

        $form = $this->createForm(AddPostFormType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $s */
            $s = $slugger->slug((string) $post->getTitle());
            $post->setSlug(strtolower($s));

            // $post->setUsers($usersRepository->find(1));
            /** @var Users $users */ // / ** @var Users|null $users */
            $users = $this->getUser();
            $post->setUsers($users);

            $featuredImage = $form->get('featuredImage')->getData();

            // $post->setFeaturedImage('default.webp');
            /** @var UploadedFile $featuredImage */
            $image = $pictureService->square($featuredImage, 'articles', 300);

            $post->setFeaturedImage($image);

            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'L\'article a été créé');

            return $this->redirectToRoute('app_profile_posts_index');
        }

        return $this->render('profile/posts/add.html.twig', [
            'form' => $form,
        ]);
    }
}
