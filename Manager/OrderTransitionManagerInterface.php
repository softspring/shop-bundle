<?php

namespace Softspring\ShopBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\ShopBundle\Model\OrderTransitionInterface;

interface OrderTransitionManagerInterface extends CrudlEntityManagerInterface
{
    /**
     * @return OrderTransitionInterface
     */
    public function createEntity();

    /**
     * @param OrderTransitionInterface $entity
     */
    public function saveEntity($entity): void;

    /**
     * @param OrderTransitionInterface $entity
     */
    public function deleteEntity($entity): void;
}