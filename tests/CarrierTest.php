<?php

namespace App\Tests;

use App\Entity\Carrier;
use PHPUnit\Framework\TestCase;

class CarrierTest extends TestCase
{
    public function testIsTrue()
    {
        $carrier = new Carrier();

        $carrier->setName('Colissimo')
            ->setDescription('Livraison en 48h')
            ->setPrice(7.99);

        $this->assertTrue($carrier->getName() === 'Colissimo');
        $this->assertTrue($carrier->getDescription() === 'Livraison en 48h');
        $this->assertTrue($carrier->getPrice() === 7.99);
    }

    public function testIsFalse()
    {
        $carrier = new Carrier();

        $carrier->setName('Chronopost')
            ->setDescription('Livraison en 24h')
            ->setPrice(14.90);

        $this->assertFalse($carrier->getName() === 'Colissimo');
        $this->assertFalse($carrier->getDescription() === 'Livraison en 48h');
        $this->assertFalse($carrier->getPrice() === 7.99);
    }

    public function testIsEmpty()
    {
        $carrier = new Carrier();

        $this->assertEmpty($carrier->getName());
        $this->assertEmpty($carrier->getDescription());
        $this->assertEmpty($carrier->getPrice());
    }
}
