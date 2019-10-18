<?php

namespace Softspring\ShopBundle\Model;

use Doctrine\Common\Collections\Collection;

interface CustomerInterface
{
    /**
     * @return Collection|OrderInterface[]
     */
    public function getOrders(): Collection;

    /**
     * @param OrderInterface $order
     */
    public function addOrder(OrderInterface $order): void;

    /**
     * @param OrderInterface $order
     */
    public function removeOrder(OrderInterface $order): void;
}