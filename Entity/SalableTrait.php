<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait SalableTrait
{
    /**
     * @var float|null
     * @ORM\Column(name="price", type="float", precision=10, scale=2, nullable=false, options={"default":0})
     */
    protected $price;

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }
}