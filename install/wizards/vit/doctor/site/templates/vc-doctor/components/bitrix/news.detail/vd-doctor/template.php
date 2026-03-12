<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>

<?php if (isset($arResult['ID'])): ?>
    <div class="vc-section" id="about">
        <div class="vc-main-about">
            <div class="vc-main-about__promo-cover">
                <div class="vc-center">
                    <div class="vc-main-about__promo-wrapper">
                        <div class="vc-main-about__promo">
                            <div class="vc-main-about__info">
                                <div class="vc-main-about__block">
                                    <div class="vc-main-about__block-title">
                                        <?= Loc::getMessage('VD_ABOUT_TITLE'); ?>
                                    </div>
                                    <h2 class="vc-main-about__title"><?= $arResult['NAME']; ?></h2>
                                </div>
                                <div class="vc-main-about__promo-desc">
                                    <?= $arResult['DETAIL_TEXT']; ?>
                                </div>
                                <?php if (isset($arResult['DISPLAY_PROPERTIES']['VIDEO']) || isset($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']) || isset($arResult['DISPLAY_PROPERTIES']['EDUCATION']) || isset($arResult['DISPLAY_PROPERTIES']['EXPERIENCE'])): ?>
                                    <div class="vc-main-about__btns">
                                        <?php if (isset($arResult['DISPLAY_PROPERTIES']['VIDEO'])): ?>
                                            <div class="vc-main-about__btn  vc-main-about__btn--video  js-open-modal" data-name="videoModal">
                                                <div class="vc-main-about__btn-icon">
                                                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/main-about/video.svg'); ?>
                                                </div>
                                                <div class="vc-main-about__btn-title">
                                                    <?= Loc::getMessage('VD_ABOUT_VIDEO'); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']) || isset($arResult['DISPLAY_PROPERTIES']['EDUCATION']) || isset($arResult['DISPLAY_PROPERTIES']['EXPERIENCE'])): ?>
                                            <a href="#data" class="vc-main-about__btn">
                                                <div class="vc-main-about__btn-title">
                                                    <?= Loc::getMessage('VD_ABOUT_COMPETENCIES'); ?>
                                                </div>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="vc-main-about__doctor">
                            <div class="vc-main-about__doctor-image">
                                <img src="<?= $arResult['DETAIL_PICTURE']['RESIZED']['src']; ?>" alt="<?= $arResult['DETAIL_PICTURE']['ALT']; ?>" class="vc-main-about__doctor-img">
                                <img src="<?= $arResult['DETAIL_PICTURE']['RESIZED']['src']; ?>" alt="<?= $arResult['DETAIL_PICTURE']['ALT']; ?>" class="vc-main-about__doctor-img-mob">
                            </div>
                        </div>
                        <?php if (!empty($arResult['PREVIEW_PICTURE'])): ?>
                            <div class="vc-main-about__promo-bg">
                                <img src="<?= $arResult['PREVIEW_PICTURE']['RESIZED']['src']; ?>" alt="<?= $arResult['PREVIEW_PICTURE']['ALT']; ?>" class="vc-main-about__promo-bg-img">
                            </div>
                        <?php endif; ?>
                        <?php if (isset($arResult['DISPLAY_PROPERTIES']['STATISTICS'])): ?>
                            <div class="vc-main-about__promo-items">
                                <?php foreach (array_keys($arResult['DISPLAY_PROPERTIES']['STATISTICS']['VALUE']) as $key): ?>
                                    <div class="vc-main-about__promo-item">
                                        <div class="vc-main-about__promo-item-title"><?= $arResult['DISPLAY_PROPERTIES']['STATISTICS']['VALUE'][$key]; ?></div>
                                        <div class="vc-main-about__promo-item-text"><?= $arResult['DISPLAY_PROPERTIES']['STATISTICS']['DESCRIPTION'][$key]; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if (isset($arResult['DISPLAY_PROPERTIES']['VIDEO'])): ?>
            <div class="vc-modal  vc-modal--video" data-name="videoModal">
                <div class="vc-modal__container">
                    <div class="vc-modal__header">
                        <div class="vc-modal__title-wrapper">
                            <div class="vc-modal__title">
                                <?= Loc::getMessage('VD_ABOUT_VIDEO'); ?>
                            </div>
                            <div class="vc-modal__close-wrapper">
                                <div class="vc-modal__close">
                                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/modal/close.svg'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="vc-modal__content">
                        <?= $arResult['DISPLAY_PROPERTIES']['VIDEO']['~VALUE']; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
