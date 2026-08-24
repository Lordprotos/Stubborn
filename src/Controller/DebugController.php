<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class DebugController extends AbstractController
{
    #[Route('/debug-env')]
    public function debug()
    {
        $stripeSecret = $_ENV['STRIPE_SECRET_KEY'] ?? 'NOT SET';
        $stripePublic = $_ENV['STRIPE_PUBLIC_KEY'] ?? 'NOT SET';
        $appUrl = $_ENV['APP_URL'] ?? 'NOT SET';

        return $this->json([
            'STRIPE_SECRET_KEY' => substr($stripeSecret, 0, 20) . '...',
            'STRIPE_PUBLIC_KEY' => substr($stripePublic, 0, 20) . '...',
            'APP_URL' => $appUrl,
        ]);
    }
}
