<?php

namespace App\Tests;

use App\Entity\Header;
use PHPUnit\Framework\TestCase;

class HeaderTest extends TestCase
{
    public function testIsTrue()
    {
        $header = new Header();
        $header->setTitle('Gros arrivage')
            ->setContent('Accédez à un catalogue de jeux, figurines et autres goodies neufs et d\'occasions règulièrement enrichi.')
            ->setBtnTitle('Découvrir')
            ->setBtnUrl('https://127.0.0.1:8000/nos-produits')
            ->setIllustration('slide_1.jpg');

        $this->assertTrue($header->getTitle() === 'Gros arrivage');
        $this->assertTrue($header->getContent() === 'Accédez à un catalogue de jeux, figurines et autres goodies neufs et d\'occasions règulièrement enrichi.');
        $this->assertTrue($header->getBtnTitle() === 'Découvrir');
        $this->assertTrue($header->getBtnUrl() === 'https://127.0.0.1:8000/nos-produits');
        $this->assertTrue($header->getIllustration() === 'slide_1.jpg');
    }

    public function testIsFalse()
    {
        $header = new Header();
        $header->setTitle('Nouveautés PS5')
            ->setContent('Découvrez Grand Theft Auto: The Trilogy – The Definitive Edition en version remasterisée.')
            ->setBtnTitle('Achetez maintenant')
            ->setBtnUrl('https://127.0.0.1:8000/produit/ps5-grand-threft-auto-5')
            ->setIllustration('slide_2.jpg');

        $this->assertFalse($header->getTitle() === 'Gros arrivage');
        $this->assertFalse($header->getContent() === 'Accédez à un catalogue de jeux, figurines et autres goodies neufs et d\'occasions règulièrement enrichi.');
        $this->assertFalse($header->getBtnTitle() === 'Découvrir');
        $this->assertFalse($header->getBtnUrl() === 'https://127.0.0.1:8000/nos-produits');
        $this->assertFalse($header->getIllustration() === 'slide_1.jpg');
    }

    public function testIsEmpty()
    {
        $header = new Header();

        $this->assertEmpty($header->getTitle());
        $this->assertEmpty($header->getContent());
        $this->assertEmpty($header->getBtnTitle());
        $this->assertEmpty($header->getBtnUrl());
        $this->assertEmpty($header->getIllustration());
    }
}
