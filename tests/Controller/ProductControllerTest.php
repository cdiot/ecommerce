<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testShouldDisplayProducts(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/our-products');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Products List');
    }

    public function testShouldDisplayProduct(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/product/ps5-grand-threft-auto-5');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'PS5 Grand Threft Auto 5');
    }
}
