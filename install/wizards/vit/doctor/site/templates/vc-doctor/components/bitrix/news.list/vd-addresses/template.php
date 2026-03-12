<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>

<?php if ($arResult['ITEMS']): ?>
    <div class="vc-branches__map">
        <div class="vc-branches-map  js-ym-container" data-baloon="<?= SITE_TEMPLATE_PATH.'/assets/img/branches-map/baloon.svg'; ?>" data-baloonopaque="<?= SITE_TEMPLATE_PATH.'/assets/img/branches-map/baloonOpaque.svg'; ?>">
            <div class="vc-branches-map__container  js-ym" data-id="branches-map" data-center="<?= $arParams['MAP_CENTER']; ?>" data-mobile-center="<?= $arParams['MAP_MOBILE_CENTER']; ?>" data-loc="<?= $arParams['MAP_CENTER']; ?>" data-zoom="<?= $arParams['ZOOM']; ?>" data-mobile-zoom="<?= $arParams['ZOOM_MOBILE']; ?>" data-active-zoom="<?= $arParams['ZOOM_ACTIVE']; ?>"></div>
            <div class="vc-branches-map__content-wrapper">
                <div class="vc-center">
                    <div class="vc-branches-map__content">
                        <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                            <div class="vc-branches-map__card  js-ym-addr" data-id="branches-map" data-loc="<?= $arItem['DISPLAY_PROPERTIES']['COORDINATES']['VALUE']; ?>"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
