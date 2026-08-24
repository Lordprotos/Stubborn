<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('', name: 'app_cart')]
    public function index(Request $request): Response
    {
        $cart = $request->getSession()->get('cart', []);

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/add/{productId}', name: 'app_cart_add', methods: ['POST'])]
    public function add(
        int $productId,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $product = $entityManager->getRepository(Product::class)->find($productId);
        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        $size = $request->request->get('size');
        $quantity = (int) $request->request->get('quantity', 1);

        $cart = $request->getSession()->get('cart', []);
        $key = $productId . '_' . $size;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'product' => $product,
                'size' => $size,
                'quantity' => $quantity,
                'price' => $product->getPrice(),
            ];
        }

        $request->getSession()->set('cart', $cart);
        $this->addFlash('success', 'Produit ajoute');

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/remove/{key}', name: 'app_cart_remove', methods: ['POST'])]
    public function remove(string $key, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $cart = $request->getSession()->get('cart', []);
        unset($cart[$key]);
        $request->getSession()->set('cart', $cart);

        $this->addFlash('success', 'Article supprime');

        return $this->redirectToRoute('app_cart');
    }
}
