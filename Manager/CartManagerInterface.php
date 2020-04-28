<?php

namespace Softspring\ShopBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Model\SalableItemInterface;
use Symfony\Component\HttpFoundation\Request;

interface CartManagerInterface extends CrudlEntityManagerInterface
{
    public function close(Request $request): void;

    public function reset(Request $request): ?OrderInterface;

    public function getCart(Request $request, bool $createIfNotExists = true): ?OrderInterface;

    public function getCartTransitionMetadata(string $transition, Request $request): array;

    public function transition(string $transition, Request $request): bool;

    public function addItem(Request $request, SalableItemInterface $item): void;

    public function removeItem(Request $request, SalableItemInterface $item): void;

    /**
     * @return OrderInterface
     */
    public function createEntity();

    /**
     * @param OrderInterface $entity
     */
    public function saveEntity($entity): void;

    /**
     * @param OrderInterface $entity
     */
    public function deleteEntity($entity): void;
}