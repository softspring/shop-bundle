<?php

namespace Softspring\ShopBundle\Model;

use Doctrine\Common\Collections\Collection;

trait MultiStoreTrait
{
    /**
     * @var Collection|StoreInterface[]
     */
    protected $stores;

    /**
     * @return Collection|StoreInterface[]
     */
    public function getStores(): Collection
    {
        return $this->stores;
    }

    /**
     * @param StoreInterface $store
     */
    public function addStore(StoreInterface $store): void
    {
        if (!$this->stores->contains($store)) {
            $this->stores->add($store);
        }
    }

    /**
     * @param StoreInterface $store
     */
    public function removeStore(StoreInterface $store): void
    {
        if ($this->stores->contains($store)) {
            $this->stores->removeElement($store);
        }
    }
}