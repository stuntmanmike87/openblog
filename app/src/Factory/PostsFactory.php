<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Posts;
use App\Repository\PostsRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Posts>
 *
 * @method        Posts|Proxy                     create(array|callable $attributes = [])
 * @method static Posts|Proxy                     createOne(array $attributes = [])
 * @method static Posts|Proxy                     find(object|array|mixed $criteria)
 * @method static Posts|Proxy                     findOrCreate(array $attributes)
 * @method static Posts|Proxy                     first(string $sortedField = 'id')
 * @method static Posts|Proxy                     last(string $sortedField = 'id')
 * @method static Posts|Proxy                     random(array $attributes = [])
 * @method static Posts|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PostsRepository|RepositoryProxy repository()
 * @method static Posts[]|Proxy[]                 all()
 * @method static Posts[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Posts[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Posts[]|Proxy[]                 findBy(array $attributes)
 * @method static Posts[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Posts[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Posts> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Posts> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Posts> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Posts> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Posts> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Posts> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Posts> random(array $attributes = [])
 * @phpstan-method static Proxy<Posts> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Posts> repository()
 * @phpstan-method static list<Proxy<Posts>> all()
 * @phpstan-method static list<Proxy<Posts>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Posts>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Posts>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Posts>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Posts>> randomSet(int $number, array $attributes = [])
 */
final class PostsFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'content' => self::faker()->text(),
            'featuredImage' => self::faker()->text(255),
            'slug' => self::faker()->text(255),
            'title' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Posts $posts): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Posts::class;
    }
}
