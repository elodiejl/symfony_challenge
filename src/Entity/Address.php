<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $number_street = null;

    #[ORM\Column(length: 255)]
    private ?string $name_street = null;

    #[ORM\Column]
    private ?string $local_code = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberStreet(): ?int
    {
        return $this->number_street;
    }

    public function setNumberStreet(int $number_street): self
    {
        $this->number_street = $number_street;

        return $this;
    }

    public function getNameStreet(): ?string
    {
        return $this->name_street;
    }

    public function setNameStreet(string $name_street): self
    {
        $this->name_street = $name_street;

        return $this;
    }

    public function getLocalCode(): ?string
    {
        return $this->local_code;
    }

    public function setLocalCode(string $local_code): self
    {
        $this->local_code = $local_code;

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
}
