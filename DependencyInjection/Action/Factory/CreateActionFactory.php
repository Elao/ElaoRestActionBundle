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
 * Create action factory
 */
class CreateActionFactory extends FormActionFactory
{
    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'rest_create';
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceId()
    {
        return 'elao_rest_action.action.create';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRoutePattern()
    {
        return '/%-names-%';
    }
}
