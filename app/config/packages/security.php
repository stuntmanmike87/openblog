<?php

declare(strict_types=1);

use App\Entity\Users;
use App\Security\UsersAuthenticator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('security', [
        'password_hashers' => [
            PasswordAuthenticatedUserInterface::class => 'auto',
        ],
        'providers' => [
            'app_user_provider' => [
                'entity' => [
                    'class' => Users::class,
                    'property' => 'nickname',
                ],
            ],
        ],
        'firewalls' => [
            'dev' => [
                'pattern' => '^/(_(profiler|wdt)|css|images|js)/',
                'security' => false,
            ],
            'main' => [
                'lazy' => true,
                'provider' => 'app_user_provider',
                'custom_authenticator' => UsersAuthenticator::class,
                'logout' => [
                    'path' => 'app_logout',
                ],
                'remember_me' => [
                    'secret' => '%kernel.secret%',
                    'lifetime' => 604800,
                    'path' => '/',
                    'always_remember_me' => true,
                ],
            ],
        ],
        'access_control' => null,
    ]);
    if ($containerConfigurator->env() === 'test') {
        $containerConfigurator->extension('security', [
            'password_hashers' => [
                PasswordAuthenticatedUserInterface::class => [
                    'algorithm' => 'auto',
                    'cost' => 4,
                    'time_cost' => 3,
                    'memory_cost' => 10,
                ],
            ],
        ]);
    }
};
