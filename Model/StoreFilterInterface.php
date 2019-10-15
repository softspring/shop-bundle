<?php

namespace Softspring\ShopBundle\Model;

interface StoreFilterInterface
{
    /**
     * @return StoreInterface|null
     */
    public function getStore(): ?StoreInterface;
}