<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!empty($arResult['PREVIEW_PICTURE'])) {
    $arResult['PREVIEW_PICTURE']['RESIZED'] = CFile::ResizeImageGet($arResult['PREVIEW_PICTURE'], ['width' => 2432, 'height' => 1280], BX_RESIZE_IMAGE_EXACT);
}

$arResult['DETAIL_PICTURE']['RESIZED'] = CFile::ResizeImageGet($arResult['DETAIL_PICTURE'], ['width' => 1120, 'height' => 1120], BX_RESIZE_IMAGE_PROPORTIONAL);
