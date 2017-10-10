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

use Elao\Bundle\AdminBundle\DependencyInjection\Action\Factory\ActionFactory as ElaoActionFactory;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Action Factory
 */
abstract class ActionFactory extends ElaoActionFactory
{
    /**
     * Repository
     *
     * @var string
     */
    protected $repository;

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        parent::addConfiguration($node);

        $node
            ->children()
                ->scalarNode('root_key')
                    ->defaultValue($this->getRootKey())
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function processConfig(array $rawConfig, array $administration, $name, $alias)
    {
        parent::processConfig($rawConfig, $administration, $name, $alias);

        $this->repository = $this->config['repository'];
        $this->serializer = $this->config['serializer'];

        unset($this->config['repository']);
        unset($this->config['serializer']);
    }

    /**
     * Configure action service
     *
     * @param Definition $definition
     * @param array $config
     */
    public function configureAction(Definition $definition)
    {
        $definition->replaceArgument(0, new Reference($this->repository));
        $definition->replaceArgument(1, new Reference($this->serializer));
        $definition->addArgument($this->config);
    }

    /**
     * Get root key for response object
     *
     * @return string
     */
    protected function getRootKey()
    {
        return '[name]';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRouteName()
    {
        return '[name]_[alias]';
    }
}
