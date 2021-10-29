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

    public function install()
    {
        $tableCreationQuery = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . '`fop_dummy` (
            `id_fop_dummy` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(32) NOT NULL,
            `isAdmin` tinyint(1) unsigned NOT NULL DEFAULT 0,
            `weight` float(11) NOT NULL,
			PRIMARY KEY (`id_fop_dummy`)
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;'
        ;

        return Db::getInstance()->execute($tableCreationQuery)
            && parent::install()
            ;
    }

    public function uninstall()
    {
        return parent::uninstall() && Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . '`fop_dummy`');
    }
}
