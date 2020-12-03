<?php

namespace Softspring\ShopBundle\Model;

interface OrderEntryInterface
{
    public function getOrder(): ?OrderInterface;

    public function setOrder(?OrderInterface $order): void;

    public function getQuantity(): int;

    public function setQuantity(int $quantity): void;

    public function getPrice(): float;

    public function setPrice(float $price): void;

    public function getSalableItem(): ?SalableItemInterface;

    public function setSalableItem(?SalableItemInterface $item): void;

    public function getTotalPrice(): float;
}