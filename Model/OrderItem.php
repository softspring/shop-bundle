<?php

namespace Softspring\ShopBundle\Model;

abstract class OrderItem implements OrderItemInterface
{
    /**
     * @var OrderInterface|null
     */
    protected $order;

    /**
     * @var SalableInterface|null
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
     * @return SalableInterface|null
     */
    public function getItem(): ?SalableInterface
    {
        return $this->item;
    }

    /**
     * @param SalableInterface|null $item
     */
    public function setItem(?SalableInterface $item): void
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