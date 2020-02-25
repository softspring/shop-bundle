<?php

namespace Softspring\ShopBundle\Model;

interface SalableItemInterface
{
    /**
     * @param StoreInterface|null $store
     *
     * @return float|null
     */
    public function getPrice(?StoreInterface $store): ?float;

    /**
     * @param StoreInterface|null $store
     *
     * @return string|null
     */
    public function getCurrency(?StoreInterface $store): ?string;
}