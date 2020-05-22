<?php

namespace Softspring\ShopBundle\Tests\Model\Examples;

use Doctrine\Common\Collections\ArrayCollection;
use Softspring\ShopBundle\Model\MultiStoreTrait;

class MultiStoreObject
{
    use MultiStoreTrait;

    public function __construct()
    {
        $this->stores = new ArrayCollection();
    }
}