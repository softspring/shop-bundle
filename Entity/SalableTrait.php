<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait SalableTrait
{
    /**
     * @var float|null
     * @ORM\Column(name="price", type="float", precision=10, scale=2, nullable=false, options={"default":0})
     */
    protected $price;

    /**
     * @var string|null
     * @ORM\Column(name="currency", type="string", length=3, nullable=false, options={"default":"EUR"})
     */
    protected $currency;

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }
}