<?php

namespace Softspring\ShopBundle\Model;

abstract class CustomerAddress implements CustomerAddressInterface
{
    /**
     * @var CustomerInterface|null
     */
    protected $customer;
}