<?php

namespace Softspring\ShopBundle\Model\Filters;

use Doctrine\Common\Collections\Collection;
use Softspring\ShopBundle\Model\StoreInterface;

interface MultiStoreFilterInterface
{
    /**
     * @return Collection|StoreInterface[]
     */
    public function getStores(): Collection;
}