<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider publicUrlProvider
     */
    public function testPublicPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->catchExceptions(false);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider privateUrlProvider
     */
    public function testPrivatePageIsSuccessful($url)
    {
        $client = static::createClient();
        $client->catchExceptions(false);
        $crawler = $client->request('GET', '/connexion');

        $buttonCrawlerNode = $crawler->selectButton('Connexion');
        $form = $buttonCrawlerNode->form();

        $form = $buttonCrawlerNode->form([
            'email' => 'foo@gmail.com',
            'password' => '123456'
        ]);

        $client->submit($form);

        $crawler = $client->request('GET', $url);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider adminUrlProvider
     */
    public function testAdminPageIsSuccessful($url)
    {
        $client = static::createClient();
        $client->catchExceptions(false);
        $crawler = $client->request('GET', '/connexion');

        $buttonCrawlerNode = $crawler->selectButton('Connexion');
        $form = $buttonCrawlerNode->form();

        $form = $buttonCrawlerNode->form([
            'email' => 'bar@ecommerce.com',
            'password' => '123456'
        ]);

        $client->submit($form);

        $crawler = $client->request('GET', $url);
        $this->assertResponseIsSuccessful();
    }

    public function publicUrlProvider()
    {
        yield 'home' => ['/'];
        yield 'app_login' => ['/connexion'];
        yield 'app_register' => ['/inscription'];
        yield 'products' => ['/nos-produits'];
        yield 'product' => ['/produit/ps5-grand-threft-auto-5'];
        yield 'cart' => ['/mon-panier'];
        yield 'contact' => ['/nous-contacter'];
    }

    public function privateUrlProvider()
    {
        yield 'account' => ['/compte'];
        yield 'account_password' => ['/compte/modifier-mon-mot-de-passe'];
        yield 'account_address' => ['/compte/adresses'];
        yield 'account_address_add' => ['/compte/ajouter-une-adresse'];
        yield 'account_address_edit' => ['/compte/modifier-une-adresse/1'];
    }

    public function adminUrlProvider()
    {
        yield 'admin' => ['/admin'];
    }
}
