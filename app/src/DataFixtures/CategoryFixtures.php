<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    public function __construct(private readonly SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $categories = [
            [
                'name' => 'France',
                'parent' => null,
            ],
            [
                'name' => 'Monde',
                'parent' => null,
            ],
            [
                'name' => 'Politique',
                'parent' => 'France',
            ],
            [
                'name' => 'Associations',
                'parent' => 'France',
            ],
            [
                'name' => 'Economie',
                'parent' => 'Monde',
            ],
        ];

        foreach ($categories as $category) {
            $newcategory = new Category();
            $newcategory->setName($category['name']);

            $slug = strtolower($this->slugger->slug((string) $newcategory->getName()));

            $newcategory->setSlug($slug);

            // On crée une référence à cette catégorie
            $this->setReference($category['name'], $newcategory);

            $parent = null;

            // On vérifie si la catégorie a un parent dans le tableau
            if (null !== $category['parent']) {
                $parent = $this->getReference($category['parent'], Category::class);
            }

            $newcategory->setParent($parent);

            $manager->persist($newcategory);
        }

        $manager->flush();
    }
}
