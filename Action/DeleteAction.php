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
use Symfony\Component\Form\Form;

/**
 * The delete action for update pages
 */
class DeleteAction extends FormAction
{
    /**
     * {@inheritdoc}
     */
    public function getResponse(Request $request)
    {
        $format = $this->getFormat($request);
        $model  = $this->getModel($request);

        $this->deleteModel($model);

        return $this->createResponse(null, 204, $format);
    }

    /**
     * {@inheritdoc}
     */
    protected function getModel(Request $request)
    {
        $model = $this->modelManager->find($request->get('_route_params'));

        if (!$model) {
            throw new NotFoundHttpException;
        }

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    protected function deleteModel($model)
    {
        $this->modelManager->delete($model);
    }
}
