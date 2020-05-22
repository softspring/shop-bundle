<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Softspring\ShopBundle\Model\ShopCustomerInterface;
use Softspring\ShopBundle\Model\OrderHasCustomerTrait as OrderHasCustomerTraitModel;

trait OrderHasCustomerTrait
{
    use OrderHasCustomerTraitModel;

    /**
     * @var ShopCustomerInterface|null
     * @ORM\ManyToOne(targetEntity="Softspring\CustomerBundle\Model\CustomerInterface", inversedBy="orders")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $customer;
}