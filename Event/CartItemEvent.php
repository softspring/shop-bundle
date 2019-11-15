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
     * @var array
     */
    protected $options;

    /**
     * CartItemEvent constructor.
     *
     * @param OrderInterface       $cart
     * @param SalableItemInterface $item
     * @param Request|null         $request
     * @param array                $options
     */
    public function __construct(OrderInterface $cart, SalableItemInterface $item, ?Request $request, array $options = [])
    {
        parent::__construct($cart, $request);
        $this->item = $item;
        $this->options = $options;
    }

    /**
     * @return SalableItemInterface
     */
    public function getItem(): SalableItemInterface
    {
        return $this->item;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}