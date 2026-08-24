<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Stock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    private array $products = [
        ['name' => 'Blackbelt', 'price' => '29.90', 'image' => 'Blackbelt.jpeg', 'featured' => true],
        ['name' => 'BlueBelt', 'price' => '29.90', 'image' => 'Bluebelt.jpeg', 'featured' => false],
        ['name' => 'Street', 'price' => '34.50', 'image' => 'Street.jpeg', 'featured' => false],
        ['name' => 'Pokeball', 'price' => '45.00', 'image' => 'Pokeball.jpeg', 'featured' => true],
        ['name' => 'PinkLady', 'price' => '29.90', 'image' => 'PinkLady.jpeg', 'featured' => false],
        ['name' => 'Snow', 'price' => '32.00', 'image' => 'Snow.jpeg', 'featured' => false],
        ['name' => 'Greyback', 'price' => '28.50', 'image' => 'Grayback.jpeg', 'featured' => false],
        ['name' => 'BlueCloud', 'price' => '45.00', 'image' => 'BlueCloud.jpeg', 'featured' => false],
        ['name' => 'BornInUsa', 'price' => '59.90', 'image' => 'BornInUsa.jpeg', 'featured' => true],
        ['name' => 'GreenSchool', 'price' => '42.20', 'image' => 'GreenSchool.jpeg', 'featured' => false],
    ];

    private array $sizes = ['XS', 'S', 'M', 'L', 'XL'];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setPrice($productData['price']);
            $product->setImageName($productData['image']);
            $product->setIsFeatured($productData['featured']);
            $product->setDescription('Sweat-shirt de qualite superieure');

            $manager->persist($product);

            foreach ($this->sizes as $size) {
                $stock = new Stock();
                $stock->setProduct($product);
                $stock->setSize($size);
                $stock->setQuantity(5);
                $manager->persist($stock);
            }
        }

        $manager->flush();
    }
}
