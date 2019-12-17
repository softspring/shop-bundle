<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Softspring\ShopBundle\Model\OrderHasCustomerInterface;
use Softspring\ShopBundle\Model\OrderInterface;

trait ShopCustomerTrait
{
    /**
     * @var Collection|OrderInterface[]
     * @ORM\OneToMany(targetEntity="Softspring\ShopBundle\Model\OrderInterface", mappedBy="customer", cascade={"persist"})
     */
    protected $orders;

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