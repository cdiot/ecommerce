<?php

namespace App\Tests;

use App\Entity\Order;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testIsTrue()
    {
        $order = new Order();
        $user = new User();
        $date = new \DateTimeImmutable();
        $order->setUser($user)
            ->setCreatedAt($date)
            ->setCarrierName('Colissimo')
            ->setCarrierPrice(7.99)
            ->setDelivery('5 Rue du Muguet Vert 02100 Saint Quentin')
            ->setState(1)
            ->setReference('30112021-5f744f4fee8a1')
            ->setStripeSessionId('b19CLCjLvEfv2BpnBPDmi83djsl4Ofk5zVegfxhdNU3oC5XrbMPB1lKKXr');

        $this->assertSame($user, $order->getUser());
        $this->assertTrue($order->getCreatedAt() === $date);
        $this->assertTrue($order->getCarrierName() === 'Colissimo');
        $this->assertTrue($order->getCarrierPrice() === 7.99);
        $this->assertTrue($order->getDelivery() === '5 Rue du Muguet Vert 02100 Saint Quentin');
        $this->assertTrue($order->getState() == 1);
        $this->assertTrue($order->getReference() == '30112021-5f744f4fee8a1');
        $this->assertTrue($order->getStripeSessionId() == 'b19CLCjLvEfv2BpnBPDmi83djsl4Ofk5zVegfxhdNU3oC5XrbMPB1lKKXr');
    }

    public function testIsFalse()
    {
        $order = new Order();
        $user = new User();
        $date = new \DateTimeImmutable();
        $yesterday = $date->modify('-1 day');
        $order->setUser($user)
            ->setCreatedAt($date)
            ->setCarrierName('Chronopost')
            ->setCarrierPrice(14.99)
            ->setDelivery('7 Rue du Muguet Vert 80000 Peronne')
            ->setState(0)
            ->setReference('30122021-5f744f4fee8a1')
            ->setStripeSessionId('b19CLCjLvEfv2BpnBPDmi83djsk5Ofk5zVegfxhdNU3oC5XrbMPB1lKKXr');

        $this->assertNotSame(new User(), $order->getUser());
        $this->assertFalse($yesterday === $date);
        $this->assertFalse($order->getCarrierName() === 'Colissimo');
        $this->assertFalse($order->getCarrierPrice() === 7.99);
        $this->assertFalse($order->getDelivery() === '5 Rue du Muguet Vert 02100 Saint Quentin');
        $this->assertFalse($order->getState() == 1);
        $this->assertFalse($order->getReference() == '30112021-5f744f4fee8a1');
        $this->assertFalse($order->getStripeSessionId() == 'b19CLCjLvEfv2BpnBPDmi83djsl4Ofk5zVegfxhdNU3oC5XrbMPB1lKKXr');
    }

    public function testIsEmpty()
    {
        $order = new Order();

        $this->assertEmpty($order->getUser());
        $this->assertEmpty($order->getCreatedAt());
        $this->assertEmpty($order->getCarrierName());
        $this->assertEmpty($order->getCarrierPrice());
        $this->assertEmpty($order->getDelivery());
        $this->assertEmpty($order->getState());
        $this->assertEmpty($order->getReference());
        $this->assertEmpty($order->getStripeSessionId());
    }
}
