<?php

namespace Softspring\ShopBundle\Model\Filters;

use Softspring\ShopBundle\Model\StoreInterface;

interface StoreFilterInterface
{
    /**
     * @return StoreInterface|null
     */
    public function getStore(): ?StoreInterface;
}