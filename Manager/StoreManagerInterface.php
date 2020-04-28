<?php

namespace Softspring\ShopBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\ShopBundle\Model\StoreInterface;

interface StoreManagerInterface extends CrudlEntityManagerInterface
{
    /**
     * @return StoreInterface
     */
    public function createEntity();

    /**
     * @param StoreInterface $entity
     */
    public function saveEntity($entity): void;

    /**
     * @param StoreInterface $entity
     */
    public function deleteEntity($entity): void;
}