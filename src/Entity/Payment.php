<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $num_card = null;

    #[ORM\Column(length: 255)]
    private ?string $name_card = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_limit = null;

    #[ORM\Column]
    private ?int $crypto_num = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCard(): ?int
    {
        return $this->num_card;
    }

    public function setNumCard(int $num_card): self
    {
        $this->num_card = $num_card;

        return $this;
    }

    public function getNameCard(): ?string
    {
        return $this->name_card;
    }

    public function setNameCard(string $name_card): self
    {
        $this->name_card = $name_card;

        return $this;
    }

    public function getDateLimit(): ?\DateTimeInterface
    {
        return $this->date_limit;
    }

    public function setDateLimit(\DateTimeInterface $date_limit): self
    {
        $this->date_limit = $date_limit;

        return $this;
    }

    public function getCryptoNum(): ?int
    {
        return $this->crypto_num;
    }

    public function setCryptoNum(int $crypto_num): self
    {
        $this->crypto_num = $crypto_num;

        return $this;
    }
}
