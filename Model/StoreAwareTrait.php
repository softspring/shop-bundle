<?php

namespace Softspring\ShopBundle\Model;

use Softspring\ShopBundle\Model\StoreInterface;

trait StoreAwareTrait
{
    /**
     * @var StoreInterface|null
     */
    protected $store;

    /**
     * @return StoreInterface|null
     */
    public function getStore(): ?StoreInterface
    {
        return $this->store;
    }

    /**
     * @param StoreInterface|null $store
     */
    public function setStore(?StoreInterface $store): void
    {
        $this->store = $store;
    }
}