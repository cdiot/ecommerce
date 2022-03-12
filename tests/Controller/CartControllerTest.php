<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    public function testShouldDisplayEmptyCart(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/mon-panier');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'Your cart is empty.');
    }
}
