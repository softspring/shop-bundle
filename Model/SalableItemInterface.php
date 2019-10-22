<?php

namespace Softspring\ShopBundle\Model;

interface SalableItemInterface
{
    /**
     * @return float|null
     */
    public function getPrice(): ?float;

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void;

    /**
     * @return string|null
     */
    public function getCurrency(): ?string;

    /**
     * @param string|null $currency
     */
    public function setCurrency(?string $currency): void;
}