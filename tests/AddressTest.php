<?php

namespace App\Tests;

use App\Entity\Address;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testIsTrue()
    {
        $address = new Address();
        $user = new User();

        $address->setUser($user)
            ->setName('Magasin')
            ->setFirstname('Gautier')
            ->setLastname('Deschelles')
            ->setCompany('Console et Jeu')
            ->setAddress('5 Rue du Muguet Vert')
            ->setPostal('02100')
            ->setCity('Saint Quentin')
            ->setCountry('France')
            ->setPhone('0620278889');

        $this->assertSame($user, $address->getUser());
        $this->assertTrue($address->getName() === 'Magasin');
        $this->assertTrue($address->getFirstname() === 'Gautier');
        $this->assertTrue($address->getLastname() === 'Deschelles');
        $this->assertTrue($address->getCompany() === 'Console et Jeu');
        $this->assertTrue($address->getAddress() === '5 Rue du Muguet Vert');
        $this->assertTrue($address->getPostal() === '02100');
        $this->assertTrue($address->getCity() === 'Saint Quentin');
        $this->assertTrue($address->getCountry() === 'France');
        $this->assertTrue($address->getPhone() === '0620278889');
    }

    public function testIsFalse()
    {
        $address = new Address();
        $user = new User();

        $address->setUser($user)
            ->setName('Mag')
            ->setFirstname('Antoine')
            ->setLastname('Dechelles')
            ->setCompany('Console Jeu')
            ->setAddress('7 Rue du Muguet Vert')
            ->setPostal('80000')
            ->setCity('Peronne')
            ->setCountry('Fr')
            ->setPhone('0631946469');

        $this->assertNotSame(new User(), $address->getUser());
        $this->assertFalse($address->getName() === 'Magasin');
        $this->assertFalse($address->getFirstname() === 'Gautier');
        $this->assertFalse($address->getLastname() === 'Deschelles');
        $this->assertFalse($address->getCompany() === 'Console et Jeu');
        $this->assertFalse($address->getAddress() === '5 Rue du Muguet Vert');
        $this->assertFalse($address->getPostal() === '02100');
        $this->assertFalse($address->getCity() === 'Saint Quentin');
        $this->assertFalse($address->getCountry() === 'France');
        $this->assertFalse($address->getPhone() === '0620278889');
    }

    public function testIsEmpty()
    {
        $address = new Address();

        $this->assertEmpty($address->getUser());
        $this->assertEmpty($address->getName());
        $this->assertEmpty($address->getFirstname());
        $this->assertEmpty($address->getLastname());
        $this->assertEmpty($address->getCompany());
        $this->assertEmpty($address->getAddress());
        $this->assertEmpty($address->getPostal());
        $this->assertEmpty($address->getCity());
        $this->assertEmpty($address->getCountry());
        $this->assertEmpty($address->getPhone());
    }
}
