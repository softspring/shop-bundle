<?php

namespace Softspring\ShopBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class Order implements OrderInterface
{
    /**
     * @var CustomerInterface|null
     */
    protected $customer;

    /**
     * @var string|null
     */
    protected $number;

    /**
     * @var string|null
     */
    protected $status;

    /**
     * @var \DateTime|null
     */
    protected $date;

    /**
     * @var Collection|OrderItemInterface[]
     */
    protected $items;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    /**
     * @param CustomerInterface|null $customer
     */
    public function setCustomer(?CustomerInterface $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string|null $number
     */
    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     */
    public function setDate(?\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return Collection|OrderItemInterface[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * @param OrderItemInterface $item
     */
    public function addItem(OrderItemInterface $item): void
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setOrder($this);
        }
    }

    /**
     * @param OrderItemInterface $item
     */
    public function removeItem(OrderItemInterface $item): void
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
        }
    }
}