<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Vit\Doctor\Schedule;

Loader::includeModule('vit.doctor');

Option::set('vit.doctor', 'site', WIZARD_SITE_ID);
Schedule::__seedData();
