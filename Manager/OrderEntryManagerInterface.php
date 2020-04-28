<?php

namespace Softspring\ShopBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\ShopBundle\Model\OrderEntryInterface;

interface OrderEntryManagerInterface extends CrudlEntityManagerInterface
{
    /**
     * @return OrderEntryInterface
     */
    public function createEntity();

    /**
     * @param OrderEntryInterface $entity
     */
    public function saveEntity($entity): void;

    /**
     * @param OrderEntryInterface $entity
     */
    public function deleteEntity($entity): void;
}