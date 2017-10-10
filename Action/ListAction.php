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
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Elao\Bundle\AdminBundle\Behaviour\FilterSetInterface;

/**
 * The default action for list pages
 */
class ListAction extends AbstractAction
{
    /**
     * Form factory
     *
     * @var FormFactoryInterface $formFactory
     */
    protected $formFactory;

    /**
     * Paginator
     *
     * @var Knp\Component\Pager\PaginatorInterface $paginator
     */
    protected $paginator;

    /**
     * Set paginator
     *
     * @param Paginator $paginator
     */
    public function setPaginator(\Knp\Component\Pager\Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Set form factory
     *
     * @param FormFactoryInterface $formFactory
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse(Request $request)
    {
        if ($filterForm = $this->createFilterForm()) {
            $filterForm->handleRequest($request);
        }

        $format  = $this->getFormat($request);
        $filters = $this->getFilters($filterForm);
        $models  = $this->getModels($request, $filters);

        return $this->createResponse(
            $this->getViewParameters($request, $models), 200, $format
        );
    }

    /**
     * Create filter form
     *
     * @return Form
     */
    protected function createFilterForm()
    {
        if (!$this->parameters['filters']['enabled']) {
            return null;
        }

        return $this->formFactory->create($this->parameters['filters']['form']);
    }

    /**
     * Get filters
     *
     * @param Form $form
     *
     * @return array
     */
    protected function getFilters(Form $form = null)
    {
        if (!$form) {
            return [];
        }

        $data = $form->getData();

        if ($data instanceof FilterSetInterface) {
            return $data->getFilters();
        }

        if (is_array($data)) {
            return array_filter($data, function ($value) {
                return $value !== null;
            });
        }

        throw new \Exception(sprintf('Unknown data type for form "%s".', $form->getName()));
    }

    /**
     * Get models
     *
     * @param Request $request
     * @param array $filters
     *
     * @return PaginationInterface|array
     */
    public function getModels(Request $request, array $filters = [])
    {
        if (!$this->parameters['pagination']['enabled']) {
            return $this->repository->findBy($filters);
        }

        $page = $request->get('page', 1);
        $perPage = $this->parameters['pagination']['per_page'];
        $paginable = $this->repository->paginate($filters);

        return $this->paginator->paginate($paginable, $page, $perPage);
    }

    /**
     * Get view parameters
     *
     * @param Request $request
     * @param array|PaginationInterface $models
     *
     * @return array
     */
    protected function getViewParameters(Request $request, $models)
    {
        return [$this->getRootKey() => $models];
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
