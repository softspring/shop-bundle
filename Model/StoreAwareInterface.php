<?php

namespace Softspring\ShopBundle\Model;

interface StoreAwareInterface
{
    /**
     * @return StoreInterface|null
     */
    public function getStore(): ?StoreInterface;

    /**
     * @param StoreInterface|null $store
     */
    public function setStore(?StoreInterface $store): void;
}