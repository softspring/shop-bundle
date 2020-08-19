<?php

namespace Softspring\ShopBundle\Exception;

use Softspring\ShopBundle\Model\OrderInterface;

class OrderTransitionNotValid extends \Exception
{
    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * @var string
     */
    protected $transition;

    /**
     * OrderTransitionNotValid constructor.
     *
     * @param OrderInterface  $order
     * @param string          $transition
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(OrderInterface $order, string $transition, $message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->order = $order;
        $this->transition = $transition;
    }

    /**
     * @return OrderInterface
     */
    public function getOrder(): OrderInterface
    {
        return $this->order;
    }

    /**
     * @return string
     */
    public function getTransition(): string
    {
        return $this->transition;
    }
}