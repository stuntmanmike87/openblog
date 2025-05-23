<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/api', name: 'api_')]
final class FileUploadController
{
    public function __construct(
        private readonly ParameterBagInterface $params,
        private readonly UrlGeneratorInterface $router,
    ) {
    }

    #[Route('/file/upload', name: 'file_upload', defaults: ['_format=json'], methods: ['post'])]
    public function fileUpload(Request $request): JsonResponse
    {
        /** @var UploadedFile $fichier */
        $fichier = $request->files->get('upload');

        $ext = explode('.', strtolower($fichier->getClientOriginalName()));
        $extension = end($ext);

        $newName = md5(uniqid()).'.'.$extension;

        /** @var string $uploads_dir */
        $uploads_dir = $this->params->get('uploads_directory');
        $path = $uploads_dir.'content/';

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $fichier->move($path, $newName);

        $link = $this->router->generate('app_main', [], UrlGeneratorInterface::ABSOLUTE_URL).'uploads/content/'.$newName;

        $response = ['url' => $link];

        return new JsonResponse($response);
    }
}
