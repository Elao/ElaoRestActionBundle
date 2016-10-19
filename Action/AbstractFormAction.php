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

use Elao\Bundle\AdminBundle\Behaviour\RepositoryInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * The default action for create and update pages
 */
abstract class AbstractFormAction extends AbstractAction
{
    /**
     * Default success code
     */
    static public $successCode = 200;

    /**
     * Default error code
     */
    static public $errorCode = 400;

    /**
     * Form factory
     *
     * @var FormFactoryInterface $formFactory
     */
    protected $formFactory;

    /**
     * Inject dependencies
     *
     * @param RepositoryInterface $repository
     * @param SerializerInterface $serializer
     * @param FormFactoryInterface $formFactory
     * @param array $parameters
     */
    public function __construct(
        RepositoryInterface $repository,
        SerializerInterface $serializer,
        FormFactoryInterface $formFactory,
        array $parameters
    ) {
        parent::__construct($repository, $serializer, $parameters);

        $this->formFactory = $formFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse(Request $request)
    {
        $format = $this->getFormat($request);
        $model  = $this->getModel($request);
        $form   = $this->createForm($model);

        $form->handleRequest($request);

        if (!$form->isValid()) {
            $this->onFormInvalid($form);

            return $this->createResponse(
                $this->getErrorViewParameters($request, $form),
                static::$errorCode,
                $format
            );
        }

        $this->onFormValid($form);

        return $this->createResponse(
            $this->getSuccessViewParameters($request, $form),
            static::$successCode,
            $format
        );
    }

    /**
     * Get model
     *
     * @param Request $request
     *
     * @return mixed
     */
    abstract protected function getModel(Request $request);

    /**
     * Create form
     *
     * @param mixed $model
     *
     * @return Form
     */
    protected function createForm($model)
    {
        return $this->formFactory
            ->create($this->parameters['form'], $model);
    }

    /**
     * On form valid
     *
     * @param Form $form
     */
    protected function onFormValid(Form $form)
    {
        $this->repository->persist($form->getData());
    }

    /**
     * On form invalid
     *
     * @param Form $form
     */
    protected function onFormInvalid(Form $form) {}

    /**
     * Get successview parameters
     *
     * @param Request $request
     * @param mixed $model
     *
     * @return mixed
     */
    protected function getSuccessViewParameters(Request $request, Form $form)
    {
        return [$this->getRootKey() => $form->getData()];
    }

    /**
     * Get successview parameters
     *
     * @param Request $request
     * @param mixed $model
     *
     * @return mixed
     */
    protected function getErrorViewParameters(Request $request, Form $form)
    {
        return ['errors' => $form->getErrors(true)];
    }

    /**
     * Get root key for response object
     *
     * @return string
     */
    protected function getRootKey()
    {
        return $this->parameters['root_key'];
    }
}
