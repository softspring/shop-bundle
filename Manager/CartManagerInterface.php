<?php

namespace Softspring\ShopBundle\Manager;

use Softspring\AdminBundle\Manager\AdminEntityManagerInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Model\SalableInterface;
use Symfony\Component\HttpFoundation\Request;

interface CartManagerInterface extends AdminEntityManagerInterface
{
    public function reset(Request $request): ?OrderInterface;

    public function getCart(Request $request): ?OrderInterface;

    public function addItem(OrderInterface $cart, SalableInterface $item): void;
}