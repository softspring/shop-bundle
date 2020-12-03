<?php

namespace Softspring\ShopBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Softspring\PaymentBundle\Model\DiscountInterface;
use Softspring\PaymentBundle\Model\DiscountRuleInterface;

trait OrderEntryHasDiscountsTrait
{
    /**
     * @var DiscountRuleInterface[]|Collection
     */
    protected $discountRules;

    /**
     * @var float
     */
    protected $priceWithDiscount = 0;

    /**
     * @var float
     */
    protected $totalPriceWithDiscount = 0;

    /**
     * @return Collection|DiscountRuleInterface[]
     */
    public function getDiscountRules(): Collection
    {
        return $this->discountRules;
    }

    public function addDiscountRule(DiscountRuleInterface $rule): void
    {
        if (!$this->getDiscountRules()->contains($rule)) {
            $this->getDiscountRules()->add($rule);
            $this->updatePrices();
        }
    }

    public function removeDiscountRule(DiscountRuleInterface $rule): void
    {
        if ($this->getDiscountRules()->contains($rule)) {
            $this->getDiscountRules()->removeElement($rule);
            $this->updatePrices();
        }
    }

    /**
     * @return Collection|DiscountInterface[]
     */
    public function getDiscounts(): Collection
    {
        return new ArrayCollection(array_unique($this->getDiscountRules()->map(function (DiscountRuleInterface $discountRule) {
            return $discountRule->getDiscount();
        })->toArray()));
    }

    /**
     * @return float
     */
    public function getPriceWithDiscount(): float
    {
        return $this->priceWithDiscount;
    }

    /**
     * @return float
     */
    public function getTotalPriceWithDiscount(): float
    {
        return $this->totalPriceWithDiscount;
    }

    /**
     * @param float $priceWithDiscount
     */
    public function setPriceWithDiscount(float $priceWithDiscount): void
    {
        $this->priceWithDiscount = $priceWithDiscount;
    }

    /**
     * @param float $totalPriceWithDiscount
     */
    public function setTotalPriceWithDiscount(float $totalPriceWithDiscount): void
    {
        $this->totalPriceWithDiscount = $totalPriceWithDiscount;
    }
}