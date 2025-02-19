<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $newPost = new Post();

        $user = $this->getReference('Admin', User::class);
        $newPost->setUser($user);
        $newPost->setTitle('Ceci est un titre');
        $newPost->setSlug(strtolower($this->slugger->slug((string) $newPost->getTitle())));
        $newPost->setContent('Ceci est le contenu');
        $newPost->setFeaturedImage('default.webp');

        $manager->persist($newPost);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
