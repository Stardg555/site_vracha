<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>

<?php if ($arResult['ITEMS']): ?>
    <div class="vc-section">
        <div class="vc-center">
            <div class="vc-gallery">
                <div class="vc-gallery__content">
                    <div class="vc-gallery__main-slider swiper-container">
                        <div class="swiper-wrapper">
                            <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                                <?php
                                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
                                ?>
                                <div class="vc-gallery__photo swiper-slide" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                                    <img src="<?= $arItem['DETAIL_PICTURE']['RESIZED']['src']; ?>" alt="<?= $arItem['DETAIL_PICTURE']['ALT']; ?>" class="vc-gallery__photo-img">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="vc-gallery__sliders">
                        <div class="vc-gallery__slider swiper-container">
                            <div class="vc-gallery__slider-wrapper  swiper-wrapper">
                                <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                                    <div class="vc-gallery__slider-slide swiper-slide">
                                        <div class="vc-gallery__slider-content">
                                            <img src="<?= $arItem['DETAIL_PICTURE']['RESIZED']['src']; ?>" alt="<?= $arItem['DETAIL_PICTURE']['ALT']; ?>" class="vc-gallery__slider-slide-img">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="vc-gallery__slider-close"></div>
                            <div class="vc-gallery__slider-nav">
                                <div class="vc-gallery__slider-arrow vc-gallery__slider-arrow--left">
                                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/gallery/arrow.svg'); ?>
                                </div>
                                <div class="vc-gallery__slider-arrow vc-gallery__slider-arrow--right vc-gallery__arrow--active">
                                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/gallery/arrow.svg'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="vc-center">
                            <div class="vc-gallery__carousel swiper-container">
                                <div class="vc-gallery__carousel-wrapper  swiper-wrapper">
                                    <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                                        <div class="vc-gallery__carousel-slide swiper-slide">
                                            <img src="<?= $arItem['DETAIL_PICTURE']['RESIZED']['src']; ?>" alt="<?= $arItem['DETAIL_PICTURE']['ALT']; ?>" class="vc-gallery__carousel-slide-img">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
