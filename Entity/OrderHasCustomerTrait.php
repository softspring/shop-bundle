<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Softspring\ShopBundle\Model\ShopCustomerInterface;

trait OrderHasCustomerTrait
{
    /**
     * @var ShopCustomerInterface|null
     * @ORM\ManyToOne(targetEntity="Softspring\CustomerBundle\Model\CustomerInterface", inversedBy="orders")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $customer;

    /**
     * @return ShopCustomerInterface|null
     */
    public function getCustomer(): ?ShopCustomerInterface
    {
        return $this->customer;
    }

    /**
     * @param ShopCustomerInterface|null $customer
     */
    public function setCustomer(?ShopCustomerInterface $customer): void
    {
        $this->customer = $customer;
    }
}