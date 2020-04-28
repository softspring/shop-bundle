<?php

namespace Softspring\ShopBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\ShopBundle\Model\ShopCustomerInterface;

interface CustomerManagerInterface extends CrudlEntityManagerInterface
{
    /**
     * @return ShopCustomerInterface
     */
    public function createEntity();

    /**
     * @param ShopCustomerInterface $entity
     */
    public function saveEntity($entity): void;

    /**
     * @param ShopCustomerInterface $entity
     */
    public function deleteEntity($entity): void;
}