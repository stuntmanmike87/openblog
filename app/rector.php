<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/assets',
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
    ]);

    return static function (RectorConfig $rectorConfig): void {
        // register single rule
        //$rectorConfig->rule(TypedPropertyFromStrictConstructorRector::class);
    
        // here we can define, what sets of rules will be applied
        // tip: use "SetList" class to autocomplete sets with your IDE
        $rectorConfig->sets([
            SetList::CODE_QUALITY
        ]);

        // basic rules
        $rectorConfig->importNames();
        $rectorConfig->importShortClasses();

        $rectorConfig->sets([
            //SetList::CODE_QUALITY,
            SetList::CODING_STYLE,
            //SetList::DEAD_CODE,
            // SetList::EARLY_RETURN,
            // SetList::INSTANCEOF,
            // SetList::NAMING,
            SetList::PHP_83,
            // SetList::PRIVATIZATION,
            // SetList::STRICT_BOOLEANS,
            // SetList::TYPE_DECLARATION,
            LevelSetList::UP_TO_PHP_83,
        ]);

        $rectorConfig->sets([
            //SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES,
            SymfonySetList::SYMFONY_64,//SYMFONY_70,
            SymfonySetList::SYMFONY_CODE_QUALITY,
            SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
        ]);
    
        // doctrine rules
        $rectorConfig->sets([
            DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES,
            DoctrineSetList::DOCTRINE_CODE_QUALITY,
        ]);

        // phpunit rules
        $rectorConfig->sets([
            //PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
            PHPUnitSetList::PHPUNIT_100,
            PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        ]);

    };
