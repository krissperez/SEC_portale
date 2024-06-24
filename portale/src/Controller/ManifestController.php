<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManifestController extends AbstractController
{
    #[Route('/site.webmanifest', name: 'manifect')]
    public function manifest(): Response
    {
        $manifest = [
            'name' => 'Sec Portale',
            'short_name' => 'Sec Portale',
            'icons' => [
                [
                    'src' => '/favicon_package_v0.16/android-chrome-192x192.png',
                    'sizes' => '300x300',
                    'type' => 'image/png'
                ]
            ],
            'start_url' => '/',
            'display' => 'standalone',
            'theme_color' => '#000000',
            'background_color' => '#ffffff'
        ];

        $response = new Response(json_encode($manifest));
        $response->headers->set('Content-Type', 'application/manifest+json');

        return $response;
    }
}