<?php

namespace Softspring\ShopBundle\Model;

class Coupon implements CouponInterface
{
    /**
     * @var string|null
     */
    protected $code;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }
}