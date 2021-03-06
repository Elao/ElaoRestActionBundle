<?php

/*
 * This file is part of the ElaoRestActionBundle.
 *
 * (c) 2014 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\RestActionBundle;

use Elao\Bundle\RestActionBundle\DependencyInjection\Action\Factory;
use Elao\Bundle\RestActionBundle\DependencyInjection\Administration\Configurator\AdministrationConfigurator;
use Elao\Bundle\RestActionBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ElaoRestActionBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new Compiler\JmsSerializerCompilerPass());
        $container->addCompilerPass(new Compiler\SymfonySerializerCompilerPass());
        $container->addCompilerPass(new Compiler\DefaultSerializerCompilerPass());

        $extension = $container->getExtension('elao_admin');
        $extension->addAdministrationConfigurator(new AdministrationConfigurator());
        $extension->addActionFactory(new Factory\ReadActionFactory());
        $extension->addActionFactory(new Factory\CreateActionFactory());
        $extension->addActionFactory(new Factory\UpdateActionFactory());
        $extension->addActionFactory(new Factory\DeleteActionFactory());
        $extension->addActionFactory(new Factory\ListActionFactory());
    }
}
