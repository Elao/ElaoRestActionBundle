<?php

/*
 * This file is part of the ElaoRestActionBundle.
 *
 * (c) 2014 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\RestActionBundle\DependencyInjection\ActionConfiguration;

use Symfony\Component\Config\Definition\Builder\NodeParentInterface;
use Elao\Bundle\AdminBundle\DependencyInjection\ActionConfiguration\ActionConfiguration;

/**
 * Handle specific configuration for the list action
 */
class ListActionConfiguration extends ActionConfiguration
{
    /**
     * {@inheritdoc}
     */
    protected function buildParametersTree(NodeParentInterface $node)
    {
        return $node
            ->arrayNode('pagination')
                ->canBeEnabled()
                ->children()
                    ->scalarNode('per_page')
                        ->defaultValue(10)
                        ->cannotBeEmpty()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('filters')
                ->canBeEnabled()
                ->children()
                    ->scalarNode('form_type')
                        ->cannotBeEmpty()
                        ->defaultValue($this->getFilterFormType())
                    ->end()
                    ->scalarNode('data')
                        ->defaultNull()
                    ->end()
                ->end()
            ->end()
            ->scalarNode('root_key')
                ->defaultValue($this->getRootKey())
                ->cannotBeEmpty()
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRouteName()
    {
        return sprintf('%s', $this->action->getAdministration()->getNameLowerCase());
    }

    /**
     * {@inheritdoc}
     */
    protected function getRoutePattern()
    {
        return sprintf('/%s', $this->action->getAdministration()->getNameUrl(true));
    }

    /**
     * {@inheritdoc}
     */
    protected function getRouteController()
    {
        return sprintf('%s:getResponse', $this->action->getServiceId());
    }

    /**
     * Get form type classname or service id for filter form
     *
     * @return string
     */
    protected function getFilterFormType()
    {
        return sprintf('%s_filter', $this->action->getAdministration()->getNameLowerCase());
    }

    /**
     * Get root key for response object
     *
     * @return string
     */
    protected function getRootKey()
    {
        return $this->action->getAdministration()->getName(true);
    }

    /**
     * {@inheritdoc}
     */
    protected function getRouteMethods()
    {
        return ['GET'];
    }
}
