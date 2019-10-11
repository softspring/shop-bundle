<?php

namespace Softspring\ShopBundle\Model;

use Doctrine\Common\Collections\Collection;

interface OrderInterface
{
    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface;

    /**
     * @return string|null
     */
    public function getNumber(): ?string;

    /**
     * @return string|null
     */
    public function getStatus(): ?string;

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime;

    /**
     * @return Collection|OrderItemInterface[]
     */
    public function getItems(): Collection;

    /**
     * @param OrderItemInterface $item
     */
    public function addItem(OrderItemInterface $item): void;

    /**
     * @param OrderItemInterface $item
     */
    public function removeItem(OrderItemInterface $item): void;
}