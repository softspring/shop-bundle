<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Model\ShopCustomerTrait as ShopCustomerTraitModel;

trait ShopCustomerTrait
{
    use ShopCustomerTraitModel;

    /**
     * @var Collection|OrderInterface[]
     * @ORM\OneToMany(targetEntity="Softspring\ShopBundle\Model\OrderInterface", mappedBy="customer", cascade={"persist"})
     */
    protected $orders;
}