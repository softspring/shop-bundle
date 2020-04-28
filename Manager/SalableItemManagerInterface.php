<?php

namespace Softspring\ShopBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\ShopBundle\Model\SalableItemInterface;

interface SalableItemManagerInterface extends CrudlEntityManagerInterface
{
    /**
     * @return SalableItemInterface
     */
    public function createEntity();

    /**
     * @param SalableItemInterface $entity
     */
    public function saveEntity($entity): void;

    /**
     * @param SalableItemInterface $entity
     */
    public function deleteEntity($entity): void;
}