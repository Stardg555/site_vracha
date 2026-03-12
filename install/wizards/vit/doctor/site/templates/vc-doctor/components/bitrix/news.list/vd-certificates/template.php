<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>

<?php if ($arResult['ITEMS']): ?>
    <div class="vc-section" id="certificates">
        <div class="vc-center">
            <div class="vc-section__header">
                <div class="vc-section__title"><?= Loc::getMessage('VD_CERTIFICATES_TITLE'); ?></div>
            </div>
            <div class="vc-section__content">
                <div class="vc-licenses">
                    <div class="vc-licenses__carousel swiper-container">
                        <div class="vc-licenses__carousel-wrapper  swiper-wrapper">
                            <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                                <?php
                                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
                                ?>
                                <div class="vc-licenses__carousel-slide swiper-slide" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                                    <div class="vc-licenses__carousel-slide-image">
                                        <img src="<?= $arItem['DETAIL_PICTURE']['RESIZED']['src']; ?>" alt="<?= $arItem['DETAIL_PICTURE']['ALT']; ?>" class="vc-licenses__carousel-slide-image-img">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="vc-licenses__carousel-nav">
                            <div class="vc-licenses__carousel-arrow  vc-licenses__carousel-arrow--left"></div>
                            <div class="vc-licenses__carousel-arrow  vc-licenses__carousel-arrow--right"></div>
                        </div>
                    </div>
                    <div class="vc-licenses__slider swiper-container">
                        <div class="vc-licenses__slider-wrapper  swiper-wrapper">
                            <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                                <div class="vc-licenses__slider-slide swiper-slide">
                                    <div class="vc-licenses__slider-slide-content">
                                        <div class="vc-licenses__slider-slide-image">
                                            <img src="<?= $arItem['DETAIL_PICTURE']['RESIZED']['src']; ?>" alt="<?= $arItem['DETAIL_PICTURE']['ALT']; ?>" class="vc-licenses__slider-slide-image-img">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="vc-licenses__slider-close"></div>
                        <div class="vc-licenses__slider-nav">
                            <div class="vc-licenses__slider-arrow  vc-licenses__slider-arrow--left"></div>
                            <div class="vc-licenses__slider-arrow  vc-licenses__slider-arrow--right"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
