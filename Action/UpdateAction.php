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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * The default action for update pages
 */
class UpdateAction extends AbstractFormAction
{
    /**
     * {@inheritdoc}
     */
    protected function getModel(Request $request)
    {
        if (!$model = $this->repository->findOneBy($request->get('_route_params'))) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}
