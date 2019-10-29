<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Softspring\ShopBundle\Model\StoreInterface;

trait StoreAwareTrait
{
    /**
     * @var StoreInterface|null
     * @ORM\ManyToOne(targetEntity="Softspring\ShopBundle\Model\StoreInterface")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id", onDelete="CASCADE")
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