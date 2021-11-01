<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider publicUrlProvider
     */
    public function testPublicPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function publicUrlProvider()
    {
        yield 'home' => ['/'];
        yield 'app_login' => ['/connexion'];
    }
}
