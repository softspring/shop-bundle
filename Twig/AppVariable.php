<?php

namespace Softspring\ShopBundle\Twig;

use Softspring\ShopBundle\Model\StoreInterface;
use Symfony\Bridge\Twig\AppVariable as BaseAppVariable;

class AppVariable extends BaseAppVariable
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