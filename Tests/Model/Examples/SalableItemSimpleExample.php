<?php

namespace Softspring\ShopBundle\Tests\Model\Examples;

use Doctrine\Common\Collections\ArrayCollection;
use Softspring\ShopBundle\Model\SalableHasPricesTrait;
use Softspring\ShopBundle\Model\SalableItemInterface;

class SalableItemSimpleExample implements SalableItemInterface
{
    use SalableHasPricesTrait;

    public function __construct()
    {
        $this->prices = new ArrayCollection();
    }
}