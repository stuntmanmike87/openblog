<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\AddCategoryFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/category', name: 'app_admin_category_')]
final class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    #[Route('/ajouter', name: 'add')]
    public function addCategory(
        Request $request,
        SluggerInterface $slugger,
        EntityManagerInterface $em,
    ): Response {
        // On initialise une catégorie
        $category = new Category();

        // On initialise le formulaire
        $categoryForm = $this->createForm(AddCategoryFormType::class, $category);

        // On traite le formulaire
        $categoryForm->handleRequest($request);

        // On vérifie si le formulaire est envoyé et valide
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            // On génère le slug
            $slug = strtolower((string) $slugger->slug((string) $category->getName()));

            // On ajoute le slug à la catégorie
            $category->setSlug($slug);

            // On enregistre la catégorie en base de données
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'La catégorie a été créée');

            return $this->redirectToRoute('app_admin_category_index');
        }

        // On affiche la vue
        return $this->render('admin/category/add.html.twig', [
            'categoryForm' => $categoryForm->createView(),
        ]);
    }
}
