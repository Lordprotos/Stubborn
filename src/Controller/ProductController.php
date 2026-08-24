<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products')]
class ProductController extends AbstractController
{
    #[Route('', name: 'app_products')]
    public function list(Request $request, ProductRepository $productRepository): Response
    {
        $priceRange = $request->query->get('price_range');
        
        $products = match($priceRange) {
            '10-29' => $productRepository->findByPriceRange(10, 29),
            '29-35' => $productRepository->findByPriceRange(29, 35),
            '35-50' => $productRepository->findByPriceRange(35, 50),
            default => $productRepository->findAll(),
        };

        return $this->render('product/list.html.twig', [
            'products' => $products,
            'price_range' => $priceRange,
        ]);
    }

    #[Route('/{id}', name: 'app_product_detail')]
    public function detail(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
    }
}
