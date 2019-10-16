<?php

namespace Softspring\ShopBundle\Model;

use Doctrine\Common\Collections\Collection;

interface MultiStoreFilterInterface
{
    /**
     * @return Collection|StoreInterface[]
     */
    public function getStores(): Collection;
}