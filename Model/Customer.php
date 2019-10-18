<?php

namespace Softspring\ShopBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class Customer implements CustomerInterface
{
    /**
     * @var Collection|OrderInterface[]
     */
    protected $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * @return Collection|OrderInterface[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    /**
     * @param OrderInterface $order
     */
    public function addOrder(OrderInterface $order): void
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);

            if ($order instanceof OrderHasCustomerInterface) {
                $order->setCustomer($this);
            }
        }
    }

    /**
     * @param OrderInterface $order
     */
    public function removeOrder(OrderInterface $order): void
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
        }
    }
}