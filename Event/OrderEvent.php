<?php

namespace Softspring\ShopBundle\Event;

use Softspring\ShopBundle\Model\OrderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class OrderEvent extends Event
{
    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * @var Request|null
     */
    protected $request;

    /**
     * OrderEvent constructor.
     *
     * @param OrderInterface $order
     * @param Request|null   $request
     */
    public function __construct(OrderInterface $order, ?Request $request)
    {
        $this->order = $order;
        $this->request = $request;
    }

    /**
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        return $this->request;
    }
}
