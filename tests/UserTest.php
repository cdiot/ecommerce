<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsTrue()
    {
        $user = new User();
        $user->setEmail('foo@test.com')
            ->setPassword('123456');

        $this->assertTrue($user->getEmail() === 'foo@test.com');
        $this->assertTrue($user->getPassword() === '123456');
    }

    public function testIsFalse()
    {
        $user = new User();
        $user->setEmail('@test.com')
            ->setPassword('azerty');

        $this->assertFalse($user->getEmail() === 'foo@test.com');
        $this->assertFalse($user->getPassword() === '123456');
    }

    public function testIsEmpty()
    {
        $user = new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getPassword());
    }
}
