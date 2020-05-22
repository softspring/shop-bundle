<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Softspring\ShopBundle\Model\StoreInterface;
use Softspring\ShopBundle\Model\MultiStoreTrait as MultiStoreTraitModel;

trait MultiStoreTrait
{
    use MultiStoreTraitModel;

    /**
     * @var Collection|StoreInterface[]
     * @ORM\ManyToMany(targetEntity="Softspring\ShopBundle\Model\StoreInterface")
     */
    protected $stores;
}