<?php

/*
 * This file is part of the ElaoRestActionBundle.
 *
 * (c) 2014 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\RestActionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('elao_rest_action');

        $rootNode
            ->children()
                ->scalarNode('serializer')
                    ->info('Serializer service for REST actions. E.g. "elao_rest_action.serializer.symfony", "elao_rest_action.serializer.jms", ect.')
                    ->defaultNull()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
