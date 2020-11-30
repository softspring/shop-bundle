<?php

namespace Softspring\ShopBundle\Model;

interface CouponRelatedPromotionInterface
{
    public function getPromotion(): ?PromotionInterface;

    public function setPromotion(?PromotionInterface $promotion): void;
}