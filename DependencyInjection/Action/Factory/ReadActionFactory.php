<?php

/*
 * This file is part of the ElaoRestActionBundle.
 *
 * (c) 2014 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\HtmlActionBundle\DependencyInjection\Action\Factory;

/**
 * Read action factory
 */
class ReadActionFactory extends ActionFactory
{
    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'rest_read';
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceId()
    {
        return 'elao_rest_action.action.read';
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
        return ['GET'];
    }
}
