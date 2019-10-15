<?php

namespace Softspring\ShopBundle\DependencyInjection;

use Softspring\ShopBundle\Model\CustomerInterface;
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
        $container->setParameter('sfs_shop.order.class', $config['order']['class']);

        // load services
        $loader->load('services.yaml');
        $loader->load('controller/admin_customers.yaml');
        $loader->load('controller/admin_orders.yaml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $doctrineConfig = [];

        // add a default config to force load target_entities, will be overwritten by ResolveDoctrineTargetEntityPass
        $doctrineConfig['orm']['resolve_target_entities'][CustomerInterface::class] = 'App\Entity\Customer';
        $doctrineConfig['orm']['resolve_target_entities'][OrderInterface::class] = 'App\Entity\Order';

        // disable auto-mapping for this bundle to prevent mapping errors
        $doctrineConfig['orm']['mappings']['SfsShopBundle'] = [
            'is_bundle' => true,
            'mapping' => false,
        ];

        $container->prependExtensionConfig('doctrine', $doctrineConfig);
    }
}