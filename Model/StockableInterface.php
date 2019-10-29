<?php

namespace Softspring\ShopBundle\Model;

interface StockableInterface
{
    /**
     * @return int|null
     */
    public function getUnits(): ?int;

    /**
     * @param int|null $units
     */
    public function setUnits(?int $units): void;

    /**
     * @return bool
     */
    public function isInStock(): bool;
}