<?php

namespace Softspring\ShopBundle\Model;

interface PriceInterface
{
    /**
     * @return float|null
     */
    public function getPrice(): ?float;

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void;
}