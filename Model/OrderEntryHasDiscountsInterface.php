<?php

namespace Softspring\ShopBundle\Model;

use Doctrine\Common\Collections\Collection;
use Softspring\PaymentBundle\Model\DiscountInterface;
use Softspring\PaymentBundle\Model\DiscountRuleInterface;

interface OrderEntryHasDiscountsInterface
{
    /**
     * @return Collection|DiscountRuleInterface[]
     */
    public function getDiscountRules(): Collection;

    public function addDiscountRule(DiscountRuleInterface $rule): void;

    public function removeDiscountRule(DiscountRuleInterface $rule): void;

    /**
     * @return Collection|DiscountInterface[]
     */
    public function getDiscounts(): Collection;

    public function getPriceWithDiscount(): float;

    public function getTotalPriceWithDiscount(): float;
}