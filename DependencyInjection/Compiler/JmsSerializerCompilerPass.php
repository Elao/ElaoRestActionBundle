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
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Jms Serializer compiler pass
 */
class JmsSerializerCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('jms_serializer')) {
            return;
        }

        $container->setDefinition(
            'elao_rest_action.serializer.jms',
            new Definition(
                'Elao\Bundle\RestActionBundle\Serializer\JmsSerializer',
                [new Reference('jms_serializer')]
            )
        );
    }
}
