<?php

namespace Softspring\ShopBundle\Model;

interface OrderItemInterface
{
    /**
     * @return OrderInterface|null
     */
    public function getOrder(): ?OrderInterface;

    /**
     * @return int|null
     */
    public function getQuantity(): ?int;

    /**
     * @param OrderInterface|null $order
     */
    public function setOrder(?OrderInterface $order): void;

    /**
     * @param int|null $quantity
     */
    public function setQuantity(?int $quantity): void;
}