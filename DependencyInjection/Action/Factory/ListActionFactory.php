<?php

/*
 * This file is part of the ElaoRestActionBundle.
 *
 * (c) 2014 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\RestActionBundle\DependencyInjection\Action\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * List action factory
 */
class ListActionFactory extends ActionFactory
{
    /**
     * {@inheritdoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        parent::addConfiguration($node);

        $node
            ->children()
                ->arrayNode('pagination')
                    ->canBeEnabled()
                    ->children()
                        ->scalarNode('paginator')
                            ->defaultValue('@knp_paginator')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('per_page')
                            ->defaultValue(10)
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('filters')
                    ->canBeEnabled()
                    ->children()
                        ->scalarNode('form')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * Configure action service
     *
     * @param Definition $definition
     * @param array $config
     */
    public function configureAction(Definition $definition)
    {
        parent::configureAction($definition);

        if ($this->config['pagination']['enabled']) {
            $definition->addMethodCall('setPaginator', new Reference($this->config['pagination']['paginator']));
        }

        if ($this->config['filters']['enabled']) {
            $definition->addMethodCall('setFormFactory', new Reference('form.factory'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'rest_list';
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceId()
    {
        return 'elao_rest_action.action.list';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRoutePattern()
    {
        return '/[-names-]';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRouteMethods()
    {
        return ['GET'];
    }

    /**
     * Get root key for response object
     *
     * @return string
     */
    protected function getRootKey()
    {
        return '[-names-]';
    }
}
