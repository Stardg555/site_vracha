<?php

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\Elements\ElementVcdoctorsTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

foreach ($arResult['PROPERTY_LIST'] as $key => $propertyID) {
	if ($arResult['PROPERTY_LIST_FULL'][$propertyID]['PROPERTY_TYPE'] == 'T') {
		array_push($arResult['PROPERTY_LIST'], $propertyID);
		unset($arResult['PROPERTY_LIST'][$key]);
		continue;
	} elseif ($arResult['PROPERTY_LIST_FULL'][$propertyID]['PROPERTY_TYPE'] == 'E') {
		if ($arResult['PROPERTY_LIST_FULL'][$propertyID]['CODE'] == 'DOCTOR') {
			$res = ElementVcdoctorsTable::getList([
				'order' => ['NAME' => 'ASC'],
				'filter' => [
					'ACTIVE' => 'Y',
					'HOME_SERVICE.ELEMENT.ACTIVE' => 'Y'
				],
				'select' => ['ID', 'NAME']
			]);
		} else {
			$res = Bitrix\Iblock\ElementTable::getList([
				'order' => ['NAME' => 'ASC'],
				'filter' => [
					'ACTIVE' => 'Y',
					'IBLOCK_ID' => $arResult['PROPERTY_LIST_FULL'][$propertyID]['LINK_IBLOCK_ID']
				],
				'select' => ['ID', 'NAME']
			]);
		}
		while ($el = $res->fetch()) {
			$arResult['PROPERTY_LIST_FULL'][$propertyID]['LIST_VALUES'][$el['ID']] = $el['NAME'];
		}
	}
}

