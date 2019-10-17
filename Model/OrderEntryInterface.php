<?php

namespace Softspring\ShopBundle\Model;

interface OrderEntryInterface
{
    /**
     * @return OrderInterface|null
     */
    public function getOrder(): ?OrderInterface;

    /**
     * @param OrderInterface|null $order
     */
    public function setOrder(?OrderInterface $order): void;

    /**
     * @return int|null
     */
    public function getQuantity(): ?int;

    /**
     * @param int|null $quantity
     */
    public function setQuantity(?int $quantity): void;

    /**
     * @return SalableItemInterface|null
     */
    public function getItem(): ?SalableItemInterface;

    /**
     * @param SalableItemInterface|null $item
     */
    public function setItem(?SalableItemInterface $item): void;

    /**
     * @return float
     */
    public function getTotalPrice(): float;
}