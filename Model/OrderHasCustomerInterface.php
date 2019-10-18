<?php

namespace Softspring\ShopBundle\Model;

interface OrderHasCustomerInterface
{
    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface;

    /**
     * @param CustomerInterface|null $customer
     */
    public function setCustomer(?CustomerInterface $customer): void;
}