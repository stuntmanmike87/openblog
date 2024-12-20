<?php

namespace App\DataFixtures;

use App\Entity\Posts;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $newPost = new Posts();
        /** @var Users|null $users */
        $users = $this->getReference('Admin', 'users');
        $newPost->setUsers($users);
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
            UsersFixtures::class,
        ];
    }
}
