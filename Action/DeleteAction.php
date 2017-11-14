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

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * The delete action for update pages
 */
class DeleteAction extends AbstractFormAction
{
    /**
     * Default success code
     */
    static public $successCode = 204;

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

    /**
     * {@inheritdoc}
     */
    protected function onFormValid(Form $form)
    {
        $this->repository->delete($form->getData());
    }

    /**
     * {@inheritdoc}
     */
    protected function getSuccessViewParameters(Request $request, Form $form)
    {
        return null;
    }
}
