<?php

namespace Softspring\ShopBundle\Model;

interface OrderHasCustomerInterface
{
    /**
     * @return ShopCustomerInterface|null
     */
    public function getCustomer(): ?ShopCustomerInterface;

    /**
     * @param ShopCustomerInterface|null $customer
     */
    public function setCustomer(?ShopCustomerInterface $customer): void;
}