<?php

namespace Softspring\ShopBundle\Model;

abstract class Price implements PriceInterface
{
    /**
     * @var float|null
     */
    protected $price;

    /**
     * @inheritDoc
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @inheritDoc
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }
}