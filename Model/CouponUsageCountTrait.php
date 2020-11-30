<?php

namespace Softspring\ShopBundle\Model;

trait CouponUsageCountTrait
{
    /**
     * @var int|null
     */
    protected $usages;

    public function getUsages(): ?int
    {
        return $this->usages;
    }

    public function setUsages(?int $usages): void
    {
        $this->usages = $usages;
    }

    public function increaseUsages(int $increase = 1): void
    {
        $this->usages = (int)$this->usages + $increase;
    }

    public function decreaseUsages(int $decrease = 1): void
    {
        $this->usages = $this->usages ? (int)$this->usages - $decrease : 0;
    }

    public function isUsed(): bool
    {
        return 0 < $this->usages;
    }
}