<?php

namespace Softspring\ShopBundle\Model;

use Doctrine\Common\Collections\Collection;

interface CustomerInterface
{
    /**
     * @return Collection|OrderInterface[]
     */
    public function getOrders(): Collection;
}