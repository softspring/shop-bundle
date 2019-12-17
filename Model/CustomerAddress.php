<?php

namespace Softspring\ShopBundle\Model;

abstract class CustomerAddress implements CustomerAddressInterface
{
    /**
     * @var ShopCustomerInterface|null
     */
    protected $customer;
}