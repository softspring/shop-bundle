<?php

namespace Softspring\ShopBundle\Event;

use Softspring\ShopBundle\Model\ShopCustomerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class CustomerEvent extends Event
{
    /**
     * @var ShopCustomerInterface
     */
    protected $customer;

    /**
     * @var Request|null
     */
    protected $request;

    /**
     * CustomerEvent constructor.
     *
     * @param ShopCustomerInterface $customer
     * @param Request|null          $request
     */
    public function __construct(ShopCustomerInterface $customer, ?Request $request)
    {
        $this->customer = $customer;
        $this->request = $request;
    }

    /**
     * @return ShopCustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        return $this->request;
    }
}