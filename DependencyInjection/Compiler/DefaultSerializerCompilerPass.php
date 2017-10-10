<?php

/*
 * This file is part of the ElaoRestActionBundle.
 *
 * (c) 2014 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\RestActionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Default Serializer compiler pass
 */
class DefaultSerializerCompilerPass implements CompilerPassInterface
{
    /**
     * Serializer candidates
     *
     * @var array
     */
    private $candidates = [
        'elao_rest_action.serializer.jms',
        'elao_rest_action.serializer.symfony',
    ];

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->has('elao_rest_action.serializer.default')) {
            return;
        }

        if ($serializer = $this->getDefaultSerializer($container)) {
            $container->setAlias('elao_rest_action.serializer.default', $serializer);
        } else {
            throw new LogicException('Could not choose a default serializer for ElaoRestActionBundle. You must enable Symfony `serializer` or JMS `jms_serializer` service or specify a `serializer` in `elao_rest_action` configuration.');
        }
    }

    /**
     * Get default serializer
     *
     * @param string $value
     *
     * @return string|null
     */
    private function getDefaultSerializer(ContainerBuilder $container)
    {
        foreach ($this->candidates as $serializer) {
            if ($container->has($serializer)) {
                return $serializer;
            }
        }

        return null;
    }
}
