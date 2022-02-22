<?php

namespace App\Entity;

use App\Repository\OrderDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderDetailsRepository::class)]
class OrderDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: "orderDetails")]
    private ?Order $myOrder = null;

    #[ORM\Column(type: "string", length: 50)]
    private ?string $product = null;

    #[ORM\Column(type: "integer")]
    private ?int $quantity = null;

    #[ORM\Column(type: "float")]
    private ?float $price = null;

    #[ORM\Column(type: "float")]
    private ?float $total = null;

    public function __toString()
    {
        return $this->getProduct() . '*' . $this->getQuantity();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMyOrder(): ?order
    {
        return $this->myOrder;
    }

    public function setMyOrder(?order $myOrder): self
    {
        $this->myOrder = $myOrder;

        return $this;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
