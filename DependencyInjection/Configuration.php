<?php

namespace Softspring\ShopBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('sfs_shop');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('entity_manager')
                    ->defaultValue('default')
                ->end()

                ->arrayNode('customer')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultValue('App\Entity\Customer')->end()
                    ->end()
                ->end()

                ->arrayNode('salable_item')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultValue('App\Entity\Product')->end()
                    ->end()
                ->end()

                ->arrayNode('order')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultValue('App\Entity\Order')->end()
                        ->arrayNode('entry')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->defaultValue('App\Entity\OrderEntry')->end()
                            ->end()
                        ->end()
                        ->arrayNode('transition')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->defaultValue('App\Entity\OrderTransition')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('store')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultNull()->end()
                        ->scalarNode('route_param_name')->defaultValue('_store')->end()
                        ->scalarNode('find_field_name')->defaultValue('id')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}