<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Keyword;
use App\Form\AddKeywordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/keyword', name: 'app_admin_keyword_')]
final class KeywordController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/keyword/index.html.twig', [
            'controller_name' => 'KeywordController',
        ]);
    }

    #[Route('/ajouter', name: 'add')]
    public function addKeyword(
        Request $request,
        SluggerInterface $slugger,
        EntityManagerInterface $em,
    ): Response {
        // On initialise un mot clé
        $keyword = new Keyword();

        // On initialise le formulaire
        $keywordForm = $this->createForm(AddKeywordFormType::class, $keyword);

        // On traite le formulaire
        $keywordForm->handleRequest($request);

        // On vérifie si le formulaire est envoyé et valide
        if ($keywordForm->isSubmitted() && $keywordForm->isValid()) {
            // On crée le slug
            $slug = strtolower((string) $slugger->slug((string) $keyword->getName()));

            // On attribue le slug à notre mot clé
            $keyword->setSlug($slug);

            // On enregistre le mot clé en base de données
            $em->persist($keyword);
            $em->flush();

            $this->addFlash('success', 'Le mot-clé a été créé');

            return $this->redirectToRoute('app_admin_keyword_index');
        }

        // On affiche la vue
        return $this->render('admin/keyword/add.html.twig', [
            'keywordForm' => $keywordForm->createView(),
        ]);
    }
}
