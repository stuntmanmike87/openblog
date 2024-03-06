<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Categories>
 *
 * @method        Categories|Proxy                     create(array|callable $attributes = [])
 * @method static Categories|Proxy                     createOne(array $attributes = [])
 * @method static Categories|Proxy                     find(object|array|mixed $criteria)
 * @method static Categories|Proxy                     findOrCreate(array $attributes)
 * @method static Categories|Proxy                     first(string $sortedField = 'id')
 * @method static Categories|Proxy                     last(string $sortedField = 'id')
 * @method static Categories|Proxy                     random(array $attributes = [])
 * @method static Categories|Proxy                     randomOrCreate(array $attributes = [])
 * @method static CategoriesRepository|RepositoryProxy repository()
 * @method static Categories[]|Proxy[]                 all()
 * @method static Categories[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Categories[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Categories[]|Proxy[]                 findBy(array $attributes)
 * @method static Categories[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Categories[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Categories> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Categories> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Categories> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Categories> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Categories> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Categories> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Categories> random(array $attributes = [])
 * @phpstan-method static Proxy<Categories> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Categories> repository()
 * @phpstan-method static list<Proxy<Categories>> all()
 * @phpstan-method static list<Proxy<Categories>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Categories>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Categories>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Categories>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Categories>> randomSet(int $number, array $attributes = [])
 */
final class CategoriesFactory extends ModelFactory
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
            'name' => self::faker()->text(50),
            'slug' => self::faker()->text(60),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Categories $categories): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Categories::class;
    }
}
