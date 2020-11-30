<?php

namespace Softspring\ShopBundle\Model;

interface CouponExpirableInterface extends CouponInterface
{
    public function isExpired(): bool;

    public function getExpirationDate(): ?\DateTimeInterface;

    public function setExpirationDate(?\DateTimeInterface $expirationDate): void;
}