<?php

require_once "vendor/autoload.php";

class Melon extends Module
{
    public function __construct()
    {
        $this->name = 'melon';
        $this->author = 'Mickaël Andrieu';
        $this->version = '1.0.0';

        parent::__construct();

        $this->displayName = $this->trans('Melon', [], 'Modules.Melon.Admin');
        $this->description = $this->trans('une description', [], 'Modules.Melon.Admin');

        $this->ps_versions_compliancy = ['min' => '1.7.8', 'max' => _PS_VERSION_];
    }
}
