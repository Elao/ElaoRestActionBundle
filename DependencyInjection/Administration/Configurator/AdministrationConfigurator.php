<?php

/*
 * This file is part of the ElaoRestActionBundle.
 *
 * (c) 2014 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\RestActionBundle\DependencyInjection\Administration\Configurator;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Elao\Bundle\AdminBundle\Behaviour\AdministrationConfiguratorInterface;

/**
 * HTML Action Administration Configurator
 */
class AdministrationConfigurator implements AdministrationConfiguratorInterface
{
    /**
     * Add configuration
     *
     * @param NodeBuilder $node
     */
    public function configure(NodeBuilder $node) {
        $node
            ->scalarNode('repository')
                ->info('Must implements Elao\Bundle\AdminBundle\Behaviour\RepositoryInterface')
                ->defaultValue($this->getRepositoryName())
                ->cannotBeEmpty()
            ->end()
            ->scalarNode('serializer')
                ->info('Must implements Symfony\Component\Serializer\SerializerInterface')
                ->defaultValue($this->getSerializer())
                ->cannotBeEmpty()
            ->end()
        ;
    }

    /**
     * Get repository service id
     *
     * @return string
     */
    protected function getRepositoryName()
    {
        return 'repository.[name]';
    }

    /**
     * Get serializer service id
     *
     * @return string
     */
    protected function getSerializer()
    {
        return 'elao_rest_action.serializer.default';
    }
}
