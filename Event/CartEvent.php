<?php

namespace Softspring\ShopBundle\Event;

use Softspring\ShopBundle\Model\OrderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class CartEvent extends Event
{
    /**
     * @var OrderInterface
     */
    protected $cart;

    /**
     * @var Request|null
     */
    protected $request;

    /**
     * CartEvent constructor.
     *
     * @param OrderInterface $cart
     * @param Request|null   $request
     */
    public function __construct(OrderInterface $cart, ?Request $request)
    {
        $this->cart = $cart;
        $this->request = $request;
    }

    /**
     * @return OrderInterface
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        return $this->request;
    }
}
