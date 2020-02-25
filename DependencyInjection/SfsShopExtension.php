<?php

namespace Softspring\ShopBundle\DependencyInjection;

use Softspring\ShopBundle\Model\ShopCustomerInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SfsShopExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));

        // set config parameters
        $container->setParameter('sfs_shop.entity_manager_name', $config['entity_manager']);
        // configure model classes
        $container->setParameter('sfs_shop.customer.class', $config['customer']['class']);
        $container->setParameter('sfs_shop.salable_item.class', $config['salable_item']['class']);
        $container->setParameter('sfs_shop.price.class', $config['price']['class']);
        $container->setParameter('sfs_shop.order.class', $config['order']['class']);
        $container->setParameter('sfs_shop.order.entry.class', $config['order']['entry']['class']);
        $container->setParameter('sfs_shop.order.transition.class', $config['order']['transition']['class'] ?? null);
        $container->setParameter('sfs_shop.store.class', $config['store']['class'] ?? null);
        $container->setParameter('sfs_shop.store.route_param_name', $config['store']['route_param_name'] ?? null);
        $container->setParameter('sfs_shop.store.find_field_name', $config['store']['find_field_name'] ?? null);

        // load services
        $loader->load('services.yaml');
        $loader->load('controller/admin_customers.yaml');
        $loader->load('controller/admin_orders.yaml');

        if ($container->getParameter('sfs_shop.store.class')) {
            $loader->load('controller/admin_stores.yaml');
            $loader->load('doctrine_filter.yaml');
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        $doctrineConfig = [];

        // add a default config to force load target_entities, will be overwritten by ResolveDoctrineTargetEntityPass
        $doctrineConfig['orm']['resolve_target_entities'][ShopCustomerInterface::class] = 'App\Entity\Customer';
        $doctrineConfig['orm']['resolve_target_entities'][OrderInterface::class] = 'App\Entity\Order';

        // disable auto-mapping for this bundle to prevent mapping errors
        $doctrineConfig['orm']['mappings']['SfsShopBundle'] = [
            'is_bundle' => true,
            'mapping' => false,
        ];

        $container->prependExtensionConfig('doctrine', $doctrineConfig);
    }
}