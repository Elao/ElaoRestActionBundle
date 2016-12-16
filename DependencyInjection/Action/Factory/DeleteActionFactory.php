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

/**
 * Delete action factory
 */
class DeleteActionFactory extends FormActionFactory
{
    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'rest_delete';
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceId()
    {
        return 'elao_rest_action.action.delete';
    }

    /**
     * {@inheritdoc}
     */
    protected function getFormType() {
        return 'Elao\Bundle\RestActionBundle\Form\Type\DeleteType';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRoutePattern()
    {
        return '/%-names-%/{id}';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRouteMethods()
    {
        return ['DELETE'];
    }
}
