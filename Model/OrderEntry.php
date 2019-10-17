<?php

namespace Softspring\ShopBundle\Model;

abstract class OrderEntry implements OrderEntryInterface
{
    /**
     * @var OrderInterface|null
     */
    protected $order;

    /**
     * @var SalableItemInterface|null
     */
    protected $item;

    /**
     * @var int|null
     */
    protected $quantity;

    /**
     * @return OrderInterface|null
     */
    public function getOrder(): ?OrderInterface
    {
        return $this->order;
    }

    /**
     * @param OrderInterface|null $order
     */
    public function setOrder(?OrderInterface $order): void
    {
        $this->order = $order;
    }

    /**
     * @return SalableItemInterface|null
     */
    public function getItem(): ?SalableItemInterface
    {
        return $this->item;
    }

    /**
     * @param SalableItemInterface|null $item
     */
    public function setItem(?SalableItemInterface $item): void
    {
        $this->item = $item;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     */
    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->item->getPrice() * $this->getQuantity();
    }
}