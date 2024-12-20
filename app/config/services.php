<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set('app.notifications.email_sender', 'anonymous@example.com');

    $parameters->set('app.jwtsecret', '%env(JWT_SECRET)%');

    $parameters->set('uploads_directory', '%kernel.project_dir%/public/uploads/');

    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\', __DIR__ . '/../src/')
        ->exclude([
        __DIR__ . '/../src/DependencyInjection/',
        __DIR__ . '/../src/Entity/',
        __DIR__ . '/../src/Kernel.php',
    ]);

    $services->load('App\\Controller\\',  __DIR__ . '/../src/Controller/')
        ->tag('controller.service_arguments');
};
