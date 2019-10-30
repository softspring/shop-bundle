<?php

namespace Softspring\ShopBundle\Event;

use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Model\SalableItemInterface;
use Symfony\Component\HttpFoundation\Request;

class CartItemEvent extends CartEvent
{
    /**
     * @var SalableItemInterface
     */
    protected $item;

    /**
     * CartItemEvent constructor.
     *
     * @param OrderInterface       $cart
     * @param SalableItemInterface $item
     * @param Request|null         $request
     */
    public function __construct(OrderInterface $cart, SalableItemInterface $item, ?Request $request)
    {
        parent::__construct($cart, $request);
        $this->item = $item;
    }

    /**
     * @return SalableItemInterface
     */
    public function getItem(): SalableItemInterface
    {
        return $this->item;
    }
}