<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Stripe\Charge;
use Stripe\Stripe;

class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'app_checkout')]
    public function checkout(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $cart = $request->getSession()->get('cart', []);
        if (empty($cart)) {
            $this->addFlash('error', 'Vide');
            return $this->redirectToRoute('app_cart');
        }
        $t = 0;
        foreach ($cart as $i) {
            $t += (float)$i['price'] * $i['quantity'];
        }
        return $this->render('checkout/index.html.twig', [
            'cart' => $cart,
            'total' => $t,
            'stripe_public_key' => $_ENV['STRIPE_PUBLIC_KEY']
        ]);
    }

    #[Route('/checkout/success', name: 'app_checkout_success', methods: ['POST'])]
    public function success(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $cart = $request->getSession()->get('cart', []);
        $request->getSession()->set('cart', []);
        $this->addFlash('success', 'OK');
        return $this->render('checkout/success.html.twig', ['total' => 0]);
    }

    #[Route('/checkout/process', name: 'app_checkout_process', methods: ['POST'])]
    public function process(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $cart = $request->getSession()->get('cart', []);
        
        if (empty($cart)) {
            return $this->redirectToRoute('app_cart');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += (float)$item['price'] * $item['quantity'];
        }

        $stripeToken = $request->request->get('stripeToken');
        
        if (!$stripeToken) {
            $this->addFlash('error', 'Token Stripe manquant');
            return $this->redirectToRoute('app_checkout');
        }

        try {
            Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

            $charge = Charge::create([
                'amount' => (int)($total * 100),
                'currency' => 'eur',
                'source' => $stripeToken,
                'description' => 'Commande Stubborn - ' . $this->getUser()->getEmail(),
                'receipt_email' => $this->getUser()->getEmail(),
            ]);

            if ($charge->status === 'succeeded') {
                $request->getSession()->set('cart', []);
                $this->addFlash('success', 'Paiement reussi!');
                return $this->render('checkout/success.html.twig', ['total' => $total]);
            }
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur paiement: ' . $e->getMessage());
            return $this->redirectToRoute('app_checkout');
        }

        return $this->redirectToRoute('app_cart');
    }
}