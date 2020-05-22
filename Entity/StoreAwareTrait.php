<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Softspring\ShopBundle\Model\StoreAwareTrait as StoreAwareTraitModel;
use Softspring\ShopBundle\Model\StoreInterface;

trait StoreAwareTrait
{
    use StoreAwareTraitModel;

    /**
     * @var StoreInterface|null
     * @ORM\ManyToOne(targetEntity="Softspring\ShopBundle\Model\StoreInterface")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $store;
}