<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testIsTrue()
    {
        $product = new Product();
        $category = new Category();

        $product->setName('PS5 Grand Threft Auto 5')
            ->setSlug('ps5-grand-threft-auto-5')
            ->setIllustration('/public/uploads/5hCsZj27K.img')
            ->setDescription('Grand Theft Auto V est un jeu vidéo d\'action-aventure, développé par Rockstar North et édité par Rockstar Games.')
            ->setPrice(79.99)
            ->setCategory($category)
            ->setIsBest(true);

        $this->assertTrue($product->getName() === 'PS5 Grand Threft Auto 5');
        $this->assertTrue($product->getSlug() === 'ps5-grand-threft-auto-5');
        $this->assertTrue($product->getIllustration() === '/public/uploads/5hCsZj27K.img');
        $this->assertTrue($product->getDescription() === 'Grand Theft Auto V est un jeu vidéo d\'action-aventure, développé par Rockstar North et édité par Rockstar Games.');
        $this->assertTrue($product->getPrice() === 79.99);
        $this->assertSame($category, $product->getCategory());
        $this->assertTrue($product->getIsBest() === true);
    }

    public function testIsFalse()
    {
        $product = new Product();
        $category = new Category();

        $product->setName('PS5 kimetsu no yaiba the hinokami chronicles')
            ->setSlug('ps5-kimetsu-no-yaiba-the-hinokami-chronicles')
            ->setIllustration('/public/uploads/7rK3P5yvB.img')
            ->setDescription('Demon Slayer: Kimetsu no Yaiba - The Hinokami Chronicles est un jeu vidéo d\'action-aventure développé par CyberConnect2 et édité par Aniplex au Japon.')
            ->setPrice(59.99)
            ->setCategory($category)
            ->setIsBest(0);

        $this->assertFalse($product->getName() === 'PS5 Grand Threft Auto 5');
        $this->assertFalse($product->getSlug() === 'ps5-grand-threft-auto-5');
        $this->assertFalse($product->getIllustration() === '/public/uploads/5hCsZj27K.img');
        $this->assertFalse($product->getDescription() === 'Grand Theft Auto V est un jeu vidéo d\'action-aventure, développé par Rockstar North et édité par Rockstar Games.');
        $this->assertFalse($product->getPrice() === 79.99);
        $this->assertNotSame(new Category(), $product->getCategory());
        $this->assertFalse($product->getIsBest() === 1);
    }

    public function testIsEmpty()
    {
        $product = new Product();

        $this->assertEmpty($product->getName());
        $this->assertEmpty($product->getSlug());
        $this->assertEmpty($product->getIllustration());
        $this->assertEmpty($product->getDescription());
        $this->assertEmpty($product->getPrice());
        $this->assertEmpty($product->getCategory());
        $this->assertEmpty($product->getIsBest());
    }
}
