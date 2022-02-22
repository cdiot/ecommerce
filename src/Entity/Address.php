<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "addresses")]
    private ?User $user = null;

    #[ORM\Column(type: "string", length: 30)]
    private ?string $name = null;

    #[ORM\Column(type: "string", length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(type: "string", length: 50)]
    private ?string $lastname = null;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    private ?string $company = null;

    #[ORM\Column(type: "string", length: 100)]
    private ?string $address = null;

    #[ORM\Column(type: "string", length: 30)]
    private ?string $postal = null;

    #[ORM\Column(type: "string", length: 50)]
    private ?string $city = null;

    #[ORM\Column(type: "string", length: 50)]
    private ?string $country = null;

    #[ORM\Column(type: "string", length: 30)]
    private ?string $phone = null;

    public function __toString(): string
    {
        return $this->getName() . '[br]' . $this->getAddress() . '[br]' . $this->getCity() . ' - ' . $this->getCountry();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostal(): ?string
    {
        return $this->postal;
    }

    public function setPostal(string $postal): self
    {
        $this->postal = $postal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
