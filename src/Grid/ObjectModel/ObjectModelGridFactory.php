<?php

namespace FOP\Melon\Grid\ObjectModel;

use PrestaShop\PrestaShop\Core\Grid\Filter\GridFilterFormFactoryInterface;
use PrestaShop\PrestaShop\Core\Grid\Grid;
use PrestaShop\PrestaShop\Core\Grid\GridFactoryInterface;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;
use PrestaShop\PrestaShop\Core\Hook\HookDispatcherInterface;
use Symfony\Component\DependencyInjection\Container;

class ObjectModelGridFactory implements GridFactoryInterface
{
    use ObjectModelAware;
    private ObjectModelDefinitionFactory $definitionFactory;
    private ObjectModelDataFactory $dataFactory;
    private GridFilterFormFactoryInterface $filterFormFactory;
    private HookDispatcherInterface $hookDispatcher;

    /**
     * @param ObjectModelDefinitionFactory $definitionFactory
     * @param ObjectModelDataFactory $dataFactory
     * @param GridFilterFormFactoryInterface $filterFormFactory
     * @param HookDispatcherInterface|null $hookDispatcher
     */
    public function __construct(
        ObjectModelDefinitionFactory $definitionFactory,
        ObjectModelDataFactory $dataFactory,
        GridFilterFormFactoryInterface $filterFormFactory,
        HookDispatcherInterface $hookDispatcher = null
    ) {
        $this->definitionFactory = $definitionFactory;
        $this->dataFactory = $dataFactory;
        $this->filterFormFactory = $filterFormFactory;

        $this->hookDispatcher = $hookDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getGrid(SearchCriteriaInterface $searchCriteria)
    {
        if (empty($this->objectModelClass)) {
            throw new \PrestaShopException('Set the object model using ``setObjectModelClass`` function.');
        }

        $definition = $this->definitionFactory
            ->setObjectModelClass($this->objectModelClass)
            ->setFields($this->getFields())
            ->getDefinition()
        ;

        $data = $this->dataFactory
            ->setObjectModelClass($this->objectModelClass)
            ->setFields($this->getFields())
            ->getData($searchCriteria);

        $this->hookDispatcher->dispatchWithParameters('action' . Container::camelize($definition->getId()) . 'GridDataModifier', [
            'data' => &$data,
        ]);

        $filterForm = $this->filterFormFactory->create($definition);
        $filterForm->setData($searchCriteria->getFilters());

        return new Grid(
            $definition,
            $data,
            $searchCriteria,
            $filterForm
        );
    }
}
