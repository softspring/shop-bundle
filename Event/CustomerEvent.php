<?php

namespace Softspring\ShopBundle\Event;

use Softspring\ShopBundle\Model\CustomerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class CustomerEvent extends Event
{
    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * @var Request|null
     */
    protected $request;

    /**
     * CustomerEvent constructor.
     *
     * @param CustomerInterface $customer
     * @param Request|null      $request
     */
    public function __construct(CustomerInterface $customer, ?Request $request)
    {
        $this->customer = $customer;
        $this->request = $request;
    }

    /**
     * @return CustomerInterface
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