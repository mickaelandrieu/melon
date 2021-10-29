<?php

namespace FOP\Melon\Grid\ObjectModel;

use PrestaShop\PrestaShop\Core\Grid\Data\Factory\GridDataFactoryInterface;
use PrestaShop\PrestaShop\Core\Grid\Data\GridData;
use PrestaShop\PrestaShop\Core\Grid\Record\RecordCollection;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;
use PrestaShopCollection;

class ObjectModelDataFactory implements GridDataFactoryInterface
{
    use ObjectModelAware;
    private string $objectModelClass = '';

    private array $fields = [];

    /**
     * {@inheritdoc}
     *
     * @todo: manage the Search Criteria
     */
    public function getData(SearchCriteriaInterface $searchCriteria)
    {
        if (empty($this->objectModelClass)) {
            throw new \PrestaShopException('Set the object model using ``setObjectModelClass`` function.');
        }

        ob_start();
        $results = (new PrestaShopCollection($this->objectModelClass))->getAll(true);
        $resultsAsArray = [];

        foreach ($results as $objectModel) {
            $vars = get_object_vars($objectModel);
            $objectModelArray = [];
            foreach ($vars as $key => $value) {
                // @todo: comment gérer proprement les champs traduisibles ?
                $objectModelArray[ltrim($key, '_')] = is_array($value) ? current($value) : $value;
            }

            $resultsAsArray[] = $objectModelArray;
        }

        $recordsCollection = new RecordCollection($resultsAsArray);
        $recordsTotal = $recordsCollection->count();

        $query = ob_get_contents();
        ob_end_clean();

        return new GridData($recordsCollection, $recordsTotal, $query);
    }
}
