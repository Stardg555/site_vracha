<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

foreach ($arResult['PROPERTY_LIST'] as $key => $propertyID) {
	if ($arResult['PROPERTY_LIST_FULL'][$propertyID]['PROPERTY_TYPE'] == 'T') {
		array_push($arResult['PROPERTY_LIST'], $propertyID);
		unset($arResult['PROPERTY_LIST'][$key]);
		continue;
	}
}
