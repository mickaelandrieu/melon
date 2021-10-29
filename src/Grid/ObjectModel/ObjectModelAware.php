<?php

namespace FOP\Melon\Grid\ObjectModel;

/**
 * Set the Object Model class name and its fields
 */
trait ObjectModelAware
{
    private string $objectModelClass = '';

    private array $fields = [];

    public function setObjectModelClass(string $objectModelClass)
    {
        $this->objectModelClass = $objectModelClass;

        return $this;
    }

    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    public function getFields() : array
    {
        return $this->fields;
    }
}
