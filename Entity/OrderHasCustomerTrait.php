<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Softspring\ShopBundle\Model\CustomerInterface;

trait OrderHasCustomerTrait
{
    /**
     * @var CustomerInterface|null
     * @ORM\ManyToOne(targetEntity="Softspring\ShopBundle\Model\CustomerInterface", inversedBy="orders")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $customer;

    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    /**
     * @param CustomerInterface|null $customer
     */
    public function setCustomer(?CustomerInterface $customer): void
    {
        $this->customer = $customer;
    }
}