<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$arTemplateParameters = [
    'MAP_CENTER' => [
        'NAME' => Loc::getMessage('VD_MAP_CENTER'),
        'TYPE' => 'STRING',
        'DEFAULT' => ''
    ],
    'MAP_MOBILE_CENTER' => [
        'NAME' => Loc::getMessage('VD_MAP_MOBILE_CENTER'),
        'TYPE' => 'STRING',
        'DEFAULT' => ''
    ],
    'ZOOM' => [
        'NAME' => Loc::getMessage('VD_ZOOM'),
        'TYPE' => 'STRING',
        'DEFAULT' => ''
    ],
    'ZOOM_MOBILE' => [
        'NAME' => Loc::getMessage('VD_ZOOM_MOBILE'),
        'TYPE' => 'STRING',
        'DEFAULT' => ''
    ],
    'ZOOM_ACTIVE' => [
        'NAME' => Loc::getMessage('VD_ZOOM_ACTIVE'),
        'TYPE' => 'STRING',
        'DEFAULT' => ''
    ]
];
