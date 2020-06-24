<?php

namespace Softspring\ShopBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\ShopBundle\Model\OrderInterface;

interface OrderManagerInterface extends CrudlEntityManagerInterface
{
    /**
     * @param string         $transition
     * @param OrderInterface $order
     * @param string         $workflowName
     *
     * @return array
     */
    public function getOrderTransitionMetadata(string $transition, OrderInterface $order, string $workflowName = 'order'): array;

    /**
     * @param string         $transition
     * @param OrderInterface $order
     * @param string         $workflowName
     *
     * @return bool
     */
    public function transition(string $transition, OrderInterface $order, string $workflowName = 'order'): bool;

    /**
     * @param string $workflowName
     *
     * @return array
     */
    public function getStatuses(string $workflowName = 'order'): array;

    /**
     * @return OrderInterface
     */
    public function createEntity();

    /**
     * @param OrderInterface $entity
     */
    public function saveEntity($entity): void;

    /**
     * @param OrderInterface $entity
     */
    public function deleteEntity($entity): void;
}