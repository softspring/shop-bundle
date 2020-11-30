<?php

namespace Softspring\ShopBundle\Model;

interface CouponUsageCountInterface extends CouponInterface
{
    public function getUsages(): ?int;

    public function setUsages(?int $usages): void;

    public function increaseUsages(int $increase = 1): void;

    public function decreaseUsages(int $decrease = 1): void;

    public function isUsed(): bool;
}