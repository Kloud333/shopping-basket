<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerDiscountRepository")
 */
class CustomerDiscount
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="id", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     *
     */
    private $customer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $discount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?int
    {
        return $this->customer;
    }

    public function setCustomer(int $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(string $discount): self
    {
        $this->discount = $discount;

        return $this;
    }
}
