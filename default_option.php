<?php

use Vit\Doctor\Helper;
use Bitrix\Main\Loader;
use Bitrix\Iblock\Elements\ElementVddoctorsTable;

Loader::includeModule('iblock');

$vit_doctor_default_option = [
    'main_color' => '#0D98FC'
];

if (Helper::getIblockIdByCode('vd-doctors')) {
    $doctorId =  ElementVddoctorsTable::getList([
        'select' => ['ID'],
        'filter' => ['ACTIVE' => 'Y'],
        'order' => ['SORT']
    ])->fetch()['ID'];

    $vit_doctor_default_option['doctor'] = $doctorId;
}
