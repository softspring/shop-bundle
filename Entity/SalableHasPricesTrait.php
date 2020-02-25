<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Softspring\ShopBundle\Model\PriceInterface;
use Softspring\ShopBundle\Model\StoreAwareInterface;
use Softspring\ShopBundle\Model\StoreInterface;

trait SalableHasPricesTrait
{
    /**
     * @var Collection|PriceInterface[]
     * @ORM\OneToMany(targetEntity="Softspring\ShopBundle\Model\PriceInterface")
     */
    protected $prices;

    use StoreAwareTrait;

    /**
     * @return Collection
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    /**
     * @param PriceInterface $price
     */
    public function addPrice(PriceInterface $price): void
    {
        if (!$this->prices->contains($price)) {
            $this->prices->add($price);
            // $price->setProduct($this);
        }
    }

    /**
     * @param PriceInterface $price
     */
    public function removePrice(PriceInterface $price): void
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
        }
    }

    /**
     * @param StoreInterface|null $store
     *
     * @return float|null
     * @throws \Exception
     */
    public function getPrice(?StoreInterface $store): ?float
    {
        if (!$store) {
            throw new \Exception('SalableHasPricesTrait requires a non empty store');
        }

        /** @var PriceInterface $price */
        $price = $this->prices->filter(function (PriceInterface $price) use ($store) {
            if (!$price instanceof StoreAwareInterface) {
                throw new \Exception('SalableHasPricesTrait requires that price class implements StoreAwareInterface');
            }

            return $price->getStore() === $store;
        })->first();

        return $price ? $price->getPrice() : 0;
    }

    /**
     * @param StoreInterface|null $store
     *
     * @return string|null
     * @throws \Exception
     */
    public function getCurrency(?StoreInterface $store): ?string
    {
        if (!$store) {
            throw new \Exception('SalableHasPricesTrait requires a non empty store');
        }

        return $store->getCurrency();
    }
}