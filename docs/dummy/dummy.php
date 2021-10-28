<?php

require_once "vendor/autoload.php";

class dummy extends Module
{
    public function __construct()
    {
        $this->name = 'dummy';
        $this->version = '0.0.1';
        $this->author = 'Friends of Presta';

        parent::__construct();

        $this->displayName = 'Dummy';
        $this->description = 'Dummy';
        $this->ps_versions_compliancy = [
            'min' => '1.7.8.0',
            'max' => _PS_VERSION_,
        ];
    }
}
