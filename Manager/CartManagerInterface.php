<?php

namespace Softspring\ShopBundle\Manager;

use Softspring\AdminBundle\Manager\AdminEntityManagerInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Model\SalableItemInterface;
use Symfony\Component\HttpFoundation\Request;

interface CartManagerInterface extends AdminEntityManagerInterface
{
    public function close(Request $request): void;

    public function reset(Request $request): ?OrderInterface;

    public function getCart(Request $request): ?OrderInterface;

    public function getCartTransitionMetadata(string $transition, Request $request): array;

    public function transition(string $transition, Request $request): bool;

    public function addItem(Request $request, SalableItemInterface $item): void;
}