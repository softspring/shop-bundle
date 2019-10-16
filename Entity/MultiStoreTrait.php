<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Softspring\ShopBundle\Model\StoreInterface;

trait MultiStoreTrait
{
    /**
     * @var Collection|StoreInterface[]
     * @ORM\ManyToMany(targetEntity="Softspring\ShopBundle\Model\StoreInterface")
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