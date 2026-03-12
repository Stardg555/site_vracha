<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>

<?php if ($arResult['ITEMS']): ?>
    <div class="vc-section" id="reviews">
        <div class="vc-center">
            <div class="vc-section__header">
                <div class="vc-section__title"><?= Loc::getMessage('VD_REVIEWS_TITLE'); ?></div>
                <div class="vc-btn  vc-btn--transparent  js-open-modal" data-name="addReviewModal">
                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/header/pen.svg'); ?>
                </div>
            </div>
        </div>
        <div class="vc-section__content">
            <div class="vc-reviews-slider">
                <div class="vc-center">
                    <div class="vc-reviews-slider__container  swiper-container">
                        <div class="vc-reviews-slider__list  swiper-wrapper">
                            <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                                <?php
                                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
                                ?>
                                <div class="vc-reviews-slider__item  swiper-slide" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                                    <div class="vc-reviews-slider__item-content">
                                        <div class="vc-reviews-slider__item-header">
                                            <div class="vc-reviews-slider__item-info-wrapper">
                                                <?php if ($arItem['DISPLAY_PROPERTIES']['PLATFORM']): ?>
                                                    <?php if ($arItem['DISPLAY_PROPERTIES']['PLATFORM_LINK']): ?>
                                                        <a href="<?= $arItem['DISPLAY_PROPERTIES']['PLATFORM_LINK']['VALUE']; ?>" target="_blank" class="vc-reviews-slider__item-icon">
                                                    <?php else: ?>
                                                        <div class="vc-reviews-slider__item-icon">
                                                    <?php endif; ?>
                                                        <?php if ($arItem['DISPLAY_PROPERTIES']['PLATFORM']['VALUE_XML_ID'] == 'PRODOCTOROV'): ?>
                                                            <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/reviews/prodoc.svg'); ?>
                                                        <?php elseif ($arItem['DISPLAY_PROPERTIES']['PLATFORM']['VALUE_XML_ID'] == 'YANDEX'): ?>
                                                            <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/reviews/yandex.svg'); ?>
                                                        <?php elseif ($arItem['DISPLAY_PROPERTIES']['PLATFORM']['VALUE_XML_ID'] == 'NAPOPRAVKU'): ?>
                                                            <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/reviews/napopravku.svg'); ?>
                                                        <?php endif; ?>
                                                    <?php if ($arItem['DISPLAY_PROPERTIES']['PLATFORM_LINK']): ?>
                                                        </a>
                                                    <?php else: ?>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <div class="vc-reviews-slider__item-info">
                                                    <div class="vc-reviews-slider__item-title">
                                                        <?= $arItem['DISPLAY_PROPERTIES']['NAME']['VALUE']; ?>
                                                    </div>
                                                    <div class="vc-reviews-slider__item-date">
                                                        <?= $arItem['DISPLAY_ACTIVE_FROM']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if ($arItem['DISPLAY_PROPERTIES']['GRADE']): ?>
                                                <div class="vc-reviews-slider__item-stars">
                                                    <?php for ($i = 0; $i < $arItem['DISPLAY_PROPERTIES']['GRADE']['VALUE'] && $i < 5; $i++): ?>
                                                        <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/reviews/star-new.svg'); ?>
                                                    <?php endfor; ?>
                                                    <?php for ($i = 0; $i < (5 - $arItem['DISPLAY_PROPERTIES']['GRADE']['VALUE']); $i++): ?>
                                                        <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/reviews/star-gray-new.svg'); ?>
                                                    <?php endfor; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="vc-reviews-slider__item-main">
                                            <?php if ($arItem['DISPLAY_PROPERTIES']['TYPE']['VALUE_XML_ID'] == "TEXT"): ?>
                                                <div class="vc-reviews-slider__item-text">
                                                    <?php if (mb_strlen($arItem['DETAIL_TEXT']) > 450): ?>
                                                        <?= TruncateText($arItem['DETAIL_TEXT'], 450); ?>
                                                        <div class="vc-reviews-slider__item-more  js-open-modal" data-name="<?= 'review-'.$arItem['ID']; ?>">
                                                            <span class="vc-reviews-slider__item-more-text"><?= Loc::getMessage('VD_READ_ENTIRE_REVIEW'); ?></span>
                                                        </div>
                                                    <?php else: ?>
                                                        <?= $arItem['DETAIL_TEXT']; ?>
                                                    <?php endif; ?>
                                                </div>
                                            <?php elseif ($arItem['DISPLAY_PROPERTIES']['TYPE']['VALUE_XML_ID'] == "VIDEO"): ?>
                                                <div class="vc-reviews-slider__video-wrapper">
                                                    <?php if (isset($arItem['DISPLAY_PROPERTIES']['VIDEO'])): ?>
                                                        <div class="vc-video">
                                                            <video muted autoplay playsinline class="vc-video__vid">
                                                                <source src="<?= $arItem['DISPLAY_PROPERTIES']['VIDEO']['FILE_VALUE']['SRC']; ?>" type="video/mp4">
                                                            </video>
                                                            <div class="vc-video__controls">
                                                                <div class="vc-video__play">
                                                                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/reviews/play.svg'); ?>
                                                                </div>
                                                                <div class="vc-video__stop">
                                                                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/reviews/stop.svg'); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                    <?php if ($arItem['DISPLAY_PROPERTIES']['TYPE']['VALUE_XML_ID'] == "TEXT" && mb_strlen($arItem['DETAIL_TEXT']) > 450): ?>
                        <div class="vc-modal  vc-modal--review" data-name="<?= 'review-'.$arItem['ID']; ?>">
                            <div class="vc-modal__container">
                                <div class="vc-modal__review-top">
                                    <div class="vc-modal__review-top-title"><?= Loc::getMessage('VD_REVIEW_TITLE'); ?></div>
                                    <div class="vc-modal__close-wrapper">
                                        <div class="vc-modal__close">
                                            <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/modal/close.svg'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="vc-modal__review-header-wrapper">
                                    <?php if ($arItem['DISPLAY_PROPERTIES']['GRADE']): ?>
                                        <div class="vc-modal__review-stars">
                                            <?php for ($i = 0; $i < $arItem['DISPLAY_PROPERTIES']['GRADE']['VALUE'] && $i < 5; $i++): ?>
                                                <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/reviews/star.svg'); ?>
                                            <?php endfor; ?>
                                            <?php for ($i = 0; $i < (5 - $arItem['DISPLAY_PROPERTIES']['GRADE']['VALUE']); $i++): ?>
                                                <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/reviews/star-gray.svg'); ?>
                                            <?php endfor; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="vc-modal__review-header">
                                        <?php if ($arItem['DISPLAY_PROPERTIES']['PLATFORM']): ?>
                                            <?php if ($arItem['DISPLAY_PROPERTIES']['PLATFORM_LINK']): ?>
                                                <a href="<?= $arItem['DISPLAY_PROPERTIES']['PLATFORM_LINK']['VALUE']; ?>" target="_blank" class="vc-modal__review-icon">
                                            <?php else: ?>
                                                <div class="vc-modal__review-icon">
                                            <?php endif; ?>
                                                <?php if ($arItem['DISPLAY_PROPERTIES']['PLATFORM']['VALUE_XML_ID'] == 'PRODOCTOROV'): ?>
                                                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/reviews/prodoc.svg'); ?>
                                                <?php elseif ($arItem['DISPLAY_PROPERTIES']['PLATFORM']['VALUE_XML_ID'] == 'YANDEX'): ?>
                                                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/reviews/yandex.svg'); ?>
                                                <?php elseif ($arItem['DISPLAY_PROPERTIES']['PLATFORM']['VALUE_XML_ID'] == 'NAPOPRAVKU'): ?>
                                                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/reviews/napopravku.svg'); ?>
                                                <?php endif; ?>
                                            <?php if ($arItem['DISPLAY_PROPERTIES']['PLATFORM_LINK']): ?>
                                                </a>
                                            <?php else: ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <div class="vc-modal__review-title">
                                            <?= $arItem['DISPLAY_PROPERTIES']['NAME']['VALUE']; ?>
                                        </div>
                                        <div class="vc-modal__review-date">
                                            <?= $arItem['DISPLAY_ACTIVE_FROM']; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="vc-modal__review-body">
                                    <div class="vc-modal__review-text">
                                        <?= $arItem['DETAIL_TEXT']; ?>
                                    </div>
                                </div>
                                <div class="vc-modal__review-btn  js-close-modal">
                                    <div class="vc-btn  vc-btn--transparent">
                                        <?= Loc::getMessage('VD_REVIEW_CLOSE'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
