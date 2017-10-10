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

/**
 * Update action factory
 */
class UpdateActionFactory extends FormActionFactory
{
    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'rest_update';
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceId()
    {
        return 'elao_rest_action.action.update';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRoutePattern()
    {
        return '/[-names-]/{id}';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRouteMethods()
    {
        return ['PUT'];
    }
}
