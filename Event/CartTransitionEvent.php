<?php

namespace Softspring\ShopBundle\Event;

use Softspring\ShopBundle\Model\OrderInterface;
use Symfony\Component\HttpFoundation\Request;

class CartTransitionEvent extends CartEvent
{
    /**
     * @var string
     */
    protected $transition;

    /**
     * @var array
     */
    protected $metadata;

    /**
     * CartTransitionEvent constructor.
     *
     * @param string         $transition
     * @param array          $metadata
     * @param OrderInterface $cart
     * @param Request|null   $request
     */
    public function __construct(string $transition, array $metadata, OrderInterface $cart, ?Request $request)
    {
        parent::__construct($cart, $request);
        $this->transition = $transition;
        $this->metadata = $metadata;
    }

    /**
     * @return string
     */
    public function getTransition(): string
    {
        return $this->transition;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }
}