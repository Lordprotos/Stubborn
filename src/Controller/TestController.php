<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test-stripe')]
    public function testStripe()
    {
        $publicKey = $_ENV['STRIPE_PUBLIC_KEY'] ?? 'NOT SET';
        $secretKey = $_ENV['STRIPE_SECRET_KEY'] ?? 'NOT SET';
        $appUrl = $_ENV['APP_URL'] ?? 'NOT SET';

        return $this->render('test.html.twig', [
            'publicKey' => substr($publicKey, 0, 10) . '...',
            'secretKey' => substr($secretKey, 0, 10) . '...',
            'appUrl' => $appUrl,
        ]);
    }
}
