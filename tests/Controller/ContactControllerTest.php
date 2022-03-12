<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testShouldDisplayContactForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/nous-contacter');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Contact us');
    }

    public function testShouldSubmitContactForm()
    {
        $client = static::createClient();
        $client->request('GET', '/nous-contacter');

        $client->submitForm('Send', [
            'contact[email]' => 'foo@gmail.com',
            'contact[subject]' => 'Collaboration',
            'contact[content]' => 'I would like to collaborate with you!'
        ]);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }
}
