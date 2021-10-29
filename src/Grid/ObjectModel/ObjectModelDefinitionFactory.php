<?php

namespace FOP\Melon\Grid\ObjectModel;

use ObjectModel;
use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\BulkActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\ViewOptionsCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\GridActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollectionInterface;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\BulkActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\DateTimeColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\GridDefinitionFactoryInterface;
use PrestaShop\PrestaShop\Core\Grid\Definition\GridDefinition;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollectionInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PrestaShopBundle\Form\Admin\Type\DatePickerType;
use FOP\Melon\Grid\Column\Type\HTMLColumn;
use Symfony\Component\Finder\Finder;

/**
 * Creates a Grid valid definition from an Object Model.
 */
class ObjectModelDefinitionFactory implements GridDefinitionFactoryInterface
{
    use ObjectModelAware;

    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        if (empty($this->objectModelClass)) {
            throw new \PrestaShopException('Set the object model using ``setObjectModelClass`` function.');
        }

        $id = $this->objectModelClass;
        $name = $this->objectModelClass;

        $columns = $this->getColumns();
        $filters = $this->getFilters();
        $actions = new GridActionCollection();
        $bulkActions = new BulkActionCollection();

        return new GridDefinition($id, $name, $columns, $filters, $actions, $bulkActions, new ViewOptionsCollection());
    }

    private function getColumns(): ColumnCollectionInterface
    {
        $columnCollection = new ColumnCollection();
        $objectModelDefinition = $this->objectModelClass::$definition;

        foreach ($objectModelDefinition['fields'] as $name => $field) {
            // guess Column Type from Definition Type

            if (!empty($this->fields) && !in_array($name, $this->fields, true)) {
                continue;
            }

            switch ($field['type']) {
                case ObjectModel::TYPE_INT:
                case ObjectModel::TYPE_STRING:
                case ObjectModel::TYPE_FLOAT:
                    $type = DataColumn::class;
                    break;
                case ObjectModel::TYPE_HTML:
                    $type = HTMLColumn::class;
                    break;
                case ObjectModel::TYPE_DATE:
                    $type = DateTimeColumn::class;

                    break;

                default:
                    $type = DataColumn::class;
            }

            // @todo: manage action columns

            $column = new $type($name);
            $column->setName($name);

            switch ($type) {
                case DataColumn::class:
                case DateTimeColumn::class:
                    $column->setOptions([
                        'field' => $name,
                        'sortable' => false,
                    ]);

                    break;
                case BulkActionColumn::class:
                    $column->setOptions([
                        'bulk_field' => $name,
                    ]);

                    break;
                default:
            }

            $columnCollection->add($column);
        }

        return $columnCollection;
    }

    private function getFilters() : FilterCollectionInterface
    {
        $filtersCollection = new FilterCollection();
        $objectModelDefinition = $this->objectModelClass::$definition;

        foreach ($objectModelDefinition['fields'] as $name => $field) {
            // guess Column Type from Definition Type

            if (!empty($this->fields) && !in_array($name, $this->fields, true)) {
                continue;
            }

            switch ($field['type']) {
                case ObjectModel::TYPE_INT:
                case ObjectModel::TYPE_STRING:
                case ObjectModel::TYPE_FLOAT:
                case ObjectModel::TYPE_HTML:
                    $type = TextType::class;

                    break;
                case ObjectModel::TYPE_DATE:
                    $type = DatePickerType::class;

                    break;

                default:
                    $type = TextType::class;
            }

            // @todo: manage action columns

            $filter = (new Filter($name, $type))->setAssociatedColumn($name);

            $filtersCollection->add($filter);
        }

        return $filtersCollection;
    }

    public function setObjectModelClass(string $objectModelClass)
    {
        // Have to patch this fuckin PS autoloader !
        $finder = new Finder();
        $finder->name($objectModelClass . '.php')->files()->in([_PS_MODULE_DIR_, _PS_ROOT_DIR_.'/classes/']);

        foreach ($finder as $file) {
            require_once $file->getRealPath();
        }

        $this->objectModelClass = $objectModelClass;

        return $this;
    }
}
