<?php

namespace Softspring\ShopBundle\Manager;

use Softspring\AdminBundle\Manager\AdminEntityManagerInterface;
use Softspring\ShopBundle\Model\OrderInterface;

interface OrderManagerInterface extends AdminEntityManagerInterface
{
    /**
     * @param string         $transition
     * @param OrderInterface $order
     *
     * @return array
     * @throws \Exception
     */
    public function getOrderTransitionMetadata(string $transition, OrderInterface $order): array;

    /**
     * @param string         $transition
     * @param OrderInterface $order
     *
     * @return bool
     * @throws \Exception
     */
    public function transition(string $transition, OrderInterface $order): bool;
}