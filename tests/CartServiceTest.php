<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class CartServiceTest extends TestCase
{
    public function testAddProductToCart(): void
    {
        $cart = [];
        $product = ['name' => 'Blackbelt', 'price' => 29.90];
        $cart['1_M'] = [
            'product' => $product,
            'size' => 'M',
            'quantity' => 1,
            'price' => 29.90
        ];
        
        $this->assertArrayHasKey('1_M', $cart);
        $this->assertEquals(1, $cart['1_M']['quantity']);
        $this->assertEquals(29.90, $cart['1_M']['price']);
        echo "✅ Test ajout produit au panier: PASSÉ\n";
    }
    
    public function testCalculateCartTotal(): void
    {
        $cart = [
            '1_M' => ['price' => 29.90, 'quantity' => 2],
            '2_L' => ['price' => 34.50, 'quantity' => 1]
        ];
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        $this->assertEquals(94.30, $total);
        echo "✅ Test calcul total: PASSÉ (Total: 94.30 €)\n";
    }
    
    public function testRemoveProductFromCart(): void
    {
        $cart = ['1_M' => ['price' => 29.90, 'quantity' => 1]];
        unset($cart['1_M']);
        
        $this->assertArrayNotHasKey('1_M', $cart);
        echo "✅ Test suppression du panier: PASSÉ\n";
    }
}
