<?php

namespace Softspring\ShopBundle\Model;

interface OrderItemInterface
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
     * @return SalableInterface|null
     */
    public function getItem(): ?SalableInterface;

    /**
     * @param SalableInterface|null $item
     */
    public function setItem(?SalableInterface $item): void;

    /**
     * @return float
     */
    public function getTotalPrice(): float;
}