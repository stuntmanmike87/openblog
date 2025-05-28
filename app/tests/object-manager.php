<?php

declare(strict_types=1);

use App\Kernel;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';//require __DIR__ . '/../vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');//(new Dotenv())->bootEnv(__DIR__ . '/../.env');

/** @var string $environment */
$environment = $_SERVER['APP_ENV'];
$kernel = new Kernel($environment, (bool) $_SERVER['APP_DEBUG']);
//Usage of super global $_SERVER found; Usage of GLOBALS are discouraged
//consider not relying on global scope
$kernel->boot();

// ** @var Registry $doctrine */
$doctrine = $kernel->getContainer()->get('doctrine');
/** @var Registry $doctrine */
return $doctrine->getManager();
