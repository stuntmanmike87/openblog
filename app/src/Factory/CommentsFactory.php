<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Comments;
use App\Repository\CommentsRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Comments>
 *
 * @method        Comments|Proxy                     create(array|callable $attributes = [])
 * @method static Comments|Proxy                     createOne(array $attributes = [])
 * @method static Comments|Proxy                     find(object|array|mixed $criteria)
 * @method static Comments|Proxy                     findOrCreate(array $attributes)
 * @method static Comments|Proxy                     first(string $sortedField = 'id')
 * @method static Comments|Proxy                     last(string $sortedField = 'id')
 * @method static Comments|Proxy                     random(array $attributes = [])
 * @method static Comments|Proxy                     randomOrCreate(array $attributes = [])
 * @method static CommentsRepository|RepositoryProxy repository()
 * @method static Comments[]|Proxy[]                 all()
 * @method static Comments[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Comments[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Comments[]|Proxy[]                 findBy(array $attributes)
 * @method static Comments[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Comments[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Comments> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Comments> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Comments> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Comments> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Comments> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Comments> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Comments> random(array $attributes = [])
 * @phpstan-method static Proxy<Comments> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Comments> repository()
 * @phpstan-method static list<Proxy<Comments>> all()
 * @phpstan-method static list<Proxy<Comments>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Comments>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Comments>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Comments>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Comments>> randomSet(int $number, array $attributes = [])
 */
final class CommentsFactory extends ModelFactory
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
            'isReply' => self::faker()->boolean(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Comments $comments): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Comments::class;
    }
}
