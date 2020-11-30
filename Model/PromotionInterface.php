<?php

namespace Softspring\ShopBundle\Model;

interface PromotionInterface
{
    public function getName(): ?string;

    public function setName(?string $name): void;

    public function isActive(): bool;

    public function setActive(bool $active): void;
}