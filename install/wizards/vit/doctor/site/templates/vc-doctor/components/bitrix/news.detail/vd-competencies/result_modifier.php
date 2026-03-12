<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

if (isset($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION'])) {
    $arResult['ACTIVE_TAB'] = 'SPECIALIZATION';
} elseif (isset($arResult['DISPLAY_PROPERTIES']['EDUCATION'])) {
    $arResult['ACTIVE_TAB'] = 'EDUCATION';
} elseif (isset($arResult['DISPLAY_PROPERTIES']['EXPERIENCE'])) {
    $arResult['ACTIVE_TAB'] = 'EXPERIENCE';
}

if (isset($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION'])) {
    $other = Loc::getMessage('VD_COMPETENCIES_SPECIALIZATION_OTHER');
    foreach (array_keys($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']['VALUE']) as $key) {
        $title = trim($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']['DESCRIPTION'][$key]) ?: $other;
        $arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']['FORMATTED'][$title][] = $arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']['VALUE'][$key];
    }
    
    if (isset($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']['FORMATTED'][$other])) {
        $arOther = $arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']['FORMATTED'][$other];
        unset($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']['FORMATTED'][$other]);
        $arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']['FORMATTED'][$other] = $arOther;

        if (count($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']['FORMATTED']) == 1) {
            $arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']['HIDE_TITLE'] = 'Y';
        }
    }
}

if (isset($arResult['DISPLAY_PROPERTIES']['EDUCATION'])) {
    foreach (array_keys($arResult['DISPLAY_PROPERTIES']['EDUCATION']['VALUE']) as $key) {
        $arValue = explode('#', $arResult['DISPLAY_PROPERTIES']['EDUCATION']['VALUE'][$key]);
        $arResult['DISPLAY_PROPERTIES']['EDUCATION']['FORMATTED'][$key] = [
            'DATES' => $arResult['DISPLAY_PROPERTIES']['EDUCATION']['DESCRIPTION'][$key],
            'TITLE' => trim($arValue[0]),
            'DESCRIPTION' => trim($arValue[1])
        ];
    }
}

if (isset($arResult['DISPLAY_PROPERTIES']['EXPERIENCE'])) {
    foreach (array_keys($arResult['DISPLAY_PROPERTIES']['EXPERIENCE']['VALUE']) as $key) {
        $arValue = explode('#', $arResult['DISPLAY_PROPERTIES']['EXPERIENCE']['VALUE'][$key]);
        $arResult['DISPLAY_PROPERTIES']['EXPERIENCE']['FORMATTED'][$key] = [
            'DATES' => $arResult['DISPLAY_PROPERTIES']['EXPERIENCE']['DESCRIPTION'][$key],
            'TITLE' => trim($arValue[0]),
            'DESCRIPTION' => trim($arValue[1])
        ];
    }
}
