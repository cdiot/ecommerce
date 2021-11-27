<?php

namespace App\Tests;

use App\Entity\Order;
use App\Entity\OrderDetails;
use PHPUnit\Framework\TestCase;

class OrderDetailsTest extends TestCase
{
    public function testIsTrue()
    {
        $orderDetails = new OrderDetails();
        $order = new Order();

        $orderDetails->setMyOrder($order)
            ->setProduct('PS5 Grand Threft Auto 5')
            ->setQuantity(1)
            ->setPrice(79.99)
            ->setTotal(79.99);

        $this->assertSame($order, $orderDetails->getMyOrder());
        $this->assertTrue($orderDetails->getProduct() === 'PS5 Grand Threft Auto 5');
        $this->assertTrue($orderDetails->getQuantity() === 1);
        $this->assertTrue($orderDetails->getPrice() === 79.99);
        $this->assertTrue($orderDetails->getTotal() === 79.99);
    }

    public function testIsFalse()
    {
        $orderDetails = new OrderDetails();
        $order = new Order();

        $orderDetails->setMyOrder($order)
            ->setProduct('PS5 kimetsu no yaiba the hinokami chronicles')
            ->setQuantity(2)
            ->setPrice(59.99)
            ->setTotal(119.98);

        $this->assertNotSame(new Order(), $orderDetails->getMyOrder());
        $this->assertFalse($orderDetails->getProduct() === 'PS5 Grand Threft Auto 5');
        $this->assertFalse($orderDetails->getQuantity() === 1);
        $this->assertFalse($orderDetails->getPrice() === 79.99);
        $this->assertFalse($orderDetails->getTotal() === 79.99);
    }

    public function testIsEmpty()
    {
        $orderDetails = new OrderDetails();

        $this->assertEmpty($orderDetails->getMyOrder());
        $this->assertEmpty($orderDetails->getProduct());
        $this->assertEmpty($orderDetails->getQuantity());
        $this->assertEmpty($orderDetails->getPrice());
        $this->assertEmpty($orderDetails->getTotal());
    }
}
