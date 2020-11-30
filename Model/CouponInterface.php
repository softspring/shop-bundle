<?php

namespace Softspring\ShopBundle\Model;

interface CouponInterface
{
    public function getCode(): ?string;

    public function setCode(?string $code);
}