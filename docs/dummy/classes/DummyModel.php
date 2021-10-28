<?php

class DummyModel extends ObjectModel
{
    public string $name = '';
    public int $age = 0;
    public bool $isAdmin = false;
    public float $weight = 0.0;
    public string $birthDate = '1970-01-01';

    public static $definition = [
        'table' => 'fop_dummy',
        'primary' => 'id_fop_dummy',
        'fields' => [
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isString',],
            'age' => ['type' => self::TYPE_INT, 'validate' => 'isInt',],
            'isAdmin' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool',],
            'weight' => ['type' => self::TYPE_FLOAT, 'validate' => 'isUnsignedFloat',],
            'birthDate' => ['type' => self::TYPE_DATE, 'validate' => 'isDateFormat',]
        ]
    ];
}
