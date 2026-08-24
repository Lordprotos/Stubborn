<?php

namespace App\Service;

use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeService
{
    private string $stripeKey;
    private string $appUrl;

    public function __construct(string $stripeSecretKey, string $appUrl)
    {
        $this->stripeKey = $stripeSecretKey;
        $this->appUrl = $appUrl;
        
        error_log('STRIPE_SECRET_KEY: ' . substr($this->stripeKey, 0, 30) . '...');
        error_log('APP_URL: ' . $this->appUrl);
        
        if (empty($this->stripeKey)) {
            throw new \RuntimeException('STRIPE_SECRET_KEY is empty!');
        }
        
        Stripe::setApiKey($this->stripeKey);
    }

    public function createCheckoutSession(array $cart, string $userEmail): string
    {
        $lineItems = [];

        foreach ($cart as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['product']->getName() . ' (Taille: ' . $item['size'] . ')',
                    ],
                    'unit_amount' => (int) ($item['price'] * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $this->appUrl . '/checkout/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $this->appUrl . '/cart',
            'customer_email' => $userEmail,
        ]);

        return $session->id;
    }

    public function getSession(string $sessionId): Session
    {
        return Session::retrieve($sessionId);
    }
}
