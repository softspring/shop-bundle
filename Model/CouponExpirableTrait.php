<?php

namespace Softspring\ShopBundle\Model;

trait CouponExpirableTrait
{
    /**
     * @var int|null
     */
    protected $expirationDate;

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate ? \DateTime::createFromFormat('U', $this->expirationDate) : null;
    }

    public function setExpirationDate(?\DateTimeInterface $expirationDate): void
    {
        $this->expirationDate = $expirationDate ? $expirationDate->format('U') : null;
    }

    public function isExpired(): bool
    {
        return $this->expirationDate && $this->expirationDate < time();
    }
}