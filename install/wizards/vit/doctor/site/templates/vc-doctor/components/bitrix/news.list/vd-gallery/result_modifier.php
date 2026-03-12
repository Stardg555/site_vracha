<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['DETAIL_PICTURE']['RESIZED'] = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'], ['width' => 1920, 'height' => 1080], BX_RESIZE_IMAGE_PROPORTIONAL);
}
unset($arItem);
