<?php

namespace Softspring\ShopBundle\Model;

trait OrderHasCustomerTrait
{
    /**
     * @var ShopCustomerInterface|null
     */
    protected $customer;

    /**
     * @return ShopCustomerInterface|null
     */
    public function getCustomer(): ?ShopCustomerInterface
    {
        return $this->customer;
    }

    /**
     * @param ShopCustomerInterface|null $customer
     */
    public function setCustomer(?ShopCustomerInterface $customer): void
    {
        $this->customer = $customer;
    }
}