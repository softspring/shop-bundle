<?php

namespace Softspring\ShopBundle\Model;

use Softspring\CatalogBundle\Model\ModelInterface;

interface OrderItemProductInterface extends OrderItemInterface
{
    /**
     * @return ModelInterface|null
     */
    public function getModel(): ?ModelInterface;
}