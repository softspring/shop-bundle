<?php

namespace Softspring\ShopBundle\DependencyInjection\Compiler;

use Softspring\CoreBundle\DependencyInjection\Compiler\AbstractResolveDoctrineTargetEntityPass;
use Softspring\ShopBundle\Model\ShopCustomerInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Model\OrderEntryInterface;
use Softspring\ShopBundle\Model\SalableItemInterface;
use Softspring\ShopBundle\Model\StoreInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ResolveDoctrineTargetEntityPass extends AbstractResolveDoctrineTargetEntityPass
{
    /**
     * @inheritDoc
     */
    protected function getEntityManagerName(ContainerBuilder $container): string
    {
        return $container->getParameter('sfs_shop.entity_manager_name');
    }

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $this->setTargetEntityFromParameter('sfs_shop.customer.class', ShopCustomerInterface::class, $container, true);
        $this->setTargetEntityFromParameter('sfs_shop.salable_item.class', SalableItemInterface::class, $container, true);
        $this->setTargetEntityFromParameter('sfs_shop.order.class', OrderInterface::class, $container, true);
        $this->setTargetEntityFromParameter('sfs_shop.order.entry.class', OrderEntryInterface::class, $container, true);
        $this->setTargetEntityFromParameter('sfs_shop.store.class', StoreInterface::class, $container, false);
    }
}