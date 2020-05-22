<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Softspring\ShopBundle\Model\PriceInterface;
use Softspring\ShopBundle\Model\StoreInterface;
use Softspring\ShopBundle\Model\SalableHasPricesTrait as SalableHasPricesTraitModel;

trait SalableHasPricesTrait
{
    use SalableHasPricesTraitModel;

    /**
     * @var Collection|PriceInterface[]
     * @ORM\OneToMany(targetEntity="Softspring\ShopBundle\Model\PriceInterface")
     */
    protected $prices;

    /**
     * @var StoreInterface|null
     * @ORM\ManyToOne(targetEntity="Softspring\ShopBundle\Model\StoreInterface")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $store;
}