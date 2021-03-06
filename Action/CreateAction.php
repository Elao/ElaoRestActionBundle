<?php

/*
 * This file is part of the ElaoRestActionBundle.
 *
 * (c) 2014 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\RestActionBundle\Action;

use Symfony\Component\HttpFoundation\Request;

/**
 * The default action for create pages
 */
class CreateAction extends AbstractFormAction
{
    /**
     * Success code
     */
    static public $successCode = 201;

    /**
     * {@inheritdoc}
     */
    protected function getModel(Request $request)
    {
        return $this->repository->create($request->get('_route_params'));
    }
}
