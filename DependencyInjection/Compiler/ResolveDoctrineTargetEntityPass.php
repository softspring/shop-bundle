<?php

namespace Softspring\ShopBundle\DependencyInjection\Compiler;

use Softspring\ShopBundle\Model\CustomerInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Model\OrderEntryInterface;
use Softspring\ShopBundle\Model\SalableItemInterface;
use Softspring\ShopBundle\Model\StoreInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\LogicException;

class ResolveDoctrineTargetEntityPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        // configure customer
        $customerClass = $container->getParameter('sfs_shop.customer.class');
        if (!class_implements($customerClass, CustomerInterface::class)) {
            throw new LogicException(sprintf('%s class must implements %s interface', $customerClass, CustomerInterface::class));
        }
        $this->setTargetEntity($container, CustomerInterface::class, $customerClass);

        // configure salable
        $salableItemClass = $container->getParameter('sfs_shop.salable_item.class');
        if (!class_implements($salableItemClass, SalableItemInterface::class)) {
            throw new LogicException(sprintf('%s class must implements %s interface', $salableItemClass, SalableItemInterface::class));
        }
        $this->setTargetEntity($container, SalableItemInterface::class, $salableItemClass);

        // configure order
        $orderClass = $container->getParameter('sfs_shop.order.class');
        if (!class_implements($orderClass, OrderInterface::class)) {
            throw new LogicException(sprintf('%s class must implements %s interface', $orderClass, OrderInterface::class));
        }
        $this->setTargetEntity($container, OrderInterface::class, $orderClass);

        // configure order item
        $orderEntryClass = $container->getParameter('sfs_shop.order.entry.class');
        if (!class_implements($orderEntryClass, OrderEntryInterface::class)) {
            throw new LogicException(sprintf('%s class must implements %s interface', $orderEntryClass, OrderEntryInterface::class));
        }
        $this->setTargetEntity($container, OrderEntryInterface::class, $orderEntryClass);

        // configure store
        if ($storeClass = $container->getParameter('sfs_shop.store.class')) {
            if (!class_implements($storeClass, StoreInterface::class)) {
                throw new LogicException(sprintf('%s class must implements %s interface', $storeClass, StoreInterface::class));
            }
            $this->setTargetEntity($container, StoreInterface::class, $storeClass);
        }
    }

    private function setTargetEntity(ContainerBuilder $container, string $interface, string $class)
    {
        $resolveTargetEntityListener = $container->findDefinition('doctrine.orm.listeners.resolve_target_entity');

        if (!$resolveTargetEntityListener->hasTag('doctrine.event_subscriber')) {
            $resolveTargetEntityListener->addTag('doctrine.event_subscriber');
        }

        $resolveTargetEntityListener->addMethodCall('addResolveTargetEntity', [$interface, $class, [$container->getParameter('sfs_shop.entity_manager_name')]]);
    }
}