<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>

<?php if ($arResult['ITEMS']): ?>
    <div class="vc-section" id="results">
        <div class="vc-center">
            <div class="vc-section__content">
                <div class="vc-results">
                    <div class="vc-results__header">
                        <div class="vc-results__title"><?= Loc::getMessage('VD_RESULTS_TITLE'); ?></div>
                        <div class="vc-results__title-slider-nav">
                            <div class="vc-results__title-arrow  vc-results__title-arrow--left">
                                <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/slider/arrow-new.svg'); ?>
                            </div>
                            <div class="vc-results__title-arrow  vc-results__title-arrow--right">
                                <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/slider/arrow-new.svg'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="vc-results__content">
                        <div class="vc-results__main  swiper-container">
                            <div class="vc-results__wrapper  swiper-wrapper">
                                <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                                    <?php
                                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]); ?>
                                    <div class="vc-results__item  swiper-slide" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                                        <div class="vc-results__block">
                                            <div class="vc-results__block-title"><?= Loc::getMessage('VD_RESULTS_BEFORE'); ?></div>
                                            <div class="vc-results__block-image">
                                                <img src="<?= $arItem['PREVIEW_PICTURE']['RESIZED']['src']; ?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT']; ?>" class="vc-results__block-image-img">
                                            </div>
                                        </div>
                                        <div class="vc-results__block">
                                            <div class="vc-results__block-title"><?= Loc::getMessage('VD_RESULTS_AFTER'); ?></div>
                                            <div class="vc-results__block-image">
                                                <img src="<?= $arItem['DETAIL_PICTURE']['RESIZED']['src']; ?>" alt="<?= $arItem['DETAIL_PICTURE']['ALT']; ?>" class="vc-results__block-image-img">
                                            </div>
                                        </div>
                                    </div>
                                <?endforeach;?>
                            </div>
                            <div class="vc-results__nav-wrapper">
                                <div class="vc-results__nav">
                                    <div class="vc-results__pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
