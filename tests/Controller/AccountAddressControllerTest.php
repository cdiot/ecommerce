<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountAddressControllerTest extends WebTestCase
{
    public function testShouldDisplayAddresses()
    {
        $client = static::createClient();
        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('foo@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/account/addresses');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Your addresses');
    }

    public function testShouldAddAddressForm()
    {
        $client = static::createClient();
        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('foo@gmail.com');

        $client->loginUser($testUser);
        $client->request('GET', '/account/add-an-address');
        $client->submitForm('Validate', [
            'address[name]' => 'King',
            'address[firstname]' => 'Louis',
            'address[lastname]' => 'Legrand',
            'address[company]' => '',
            'address[address]' => 'Place d\'Armes',
            'address[postal]' => '78000',
            'address[city]' => 'Versailles',
            'address[country]' => 'FR',
            'address[phone]' => '0130837800'
        ]);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testShouldEditAddressForm()
    {
        $client = static::createClient();
        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('foo@gmail.com');

        $client->loginUser($testUser);
        // user is now logged in, so you can test protected resources
        $crawler = $client->request('GET', '/account/modify-an-address/2');
        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Validate');

        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();

        // set values on a form object
        $form['address[name]'] = 'President';
        $form['address[firstname]'] = 'Louis';
        $form['address[lastname]'] = 'Lepetit';
        $form['address[company]'] = '';
        $form['address[address]'] = '55 Rue du Faubourg Saint-Honoré';
        $form['address[postal]'] = '75008';
        $form['address[city]'] = 'Paris';
        $form['address[country]'] = 'FR';
        $form['address[phone]'] = '0142928100';

        // submit the Form object
        $client->submit($form);

        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testShouldDisplayDeleteAddress()
    {
        $client = static::createClient();
        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('foo@gmail.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/account/delete-an-address/2');
        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }
}
