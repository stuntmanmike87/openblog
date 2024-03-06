<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Keywords;
use App\Repository\KeywordsRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Keywords>
 *
 * @method        Keywords|Proxy                     create(array|callable $attributes = [])
 * @method static Keywords|Proxy                     createOne(array $attributes = [])
 * @method static Keywords|Proxy                     find(object|array|mixed $criteria)
 * @method static Keywords|Proxy                     findOrCreate(array $attributes)
 * @method static Keywords|Proxy                     first(string $sortedField = 'id')
 * @method static Keywords|Proxy                     last(string $sortedField = 'id')
 * @method static Keywords|Proxy                     random(array $attributes = [])
 * @method static Keywords|Proxy                     randomOrCreate(array $attributes = [])
 * @method static KeywordsRepository|RepositoryProxy repository()
 * @method static Keywords[]|Proxy[]                 all()
 * @method static Keywords[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Keywords[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Keywords[]|Proxy[]                 findBy(array $attributes)
 * @method static Keywords[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Keywords[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Keywords> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Keywords> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Keywords> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Keywords> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Keywords> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Keywords> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Keywords> random(array $attributes = [])
 * @phpstan-method static Proxy<Keywords> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Keywords> repository()
 * @phpstan-method static list<Proxy<Keywords>> all()
 * @phpstan-method static list<Proxy<Keywords>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Keywords>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Keywords>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Keywords>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Keywords>> randomSet(int $number, array $attributes = [])
 */
final class KeywordsFactory extends ModelFactory
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
            // ->afterInstantiate(function(Keywords $keywords): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Keywords::class;
    }
}
