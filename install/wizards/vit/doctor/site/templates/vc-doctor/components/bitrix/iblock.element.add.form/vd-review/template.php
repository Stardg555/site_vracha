<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use \Bitrix\Main\Localization\Loc;

$this->setFrameMode(false);
?>

<div class="vc-modal  vc-modal--review" data-name="addReviewModal">
	<div class="vc-modal__container">
        <div class="vc-modal__header">
            <div class="vc-modal__title-wrapper">
                <div class="vc-modal__title">
                    <?= Loc::getMessage('REVIEW_FORM_TITLE'); ?>
                </div>
                <div class="vc-modal__close-wrapper">
                    <div class="vc-modal__close">
                        <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/modal/close.svg'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="vc-modal__content">
            <div class="vc-record-form">
                <form class="vc-record-form__form  js-record-form" id="add-review-form" action="<?= POST_FORM_ACTION_URI; ?>" method="post" enctype="multipart/form-data">
                    <?= bitrix_sessid_post(); ?>
                    <?php if ($arResult['MESSAGE']): ?>
                        <div class="vc-modal__success">
                            <div class="vc-modal__success-header">
                                <div class="vc-modal__success-title">
                                    <?= $arResult['MESSAGE']; ?>
                                </div>
                                <div class="vc-modal__success-close  js-close-modal">
                                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/modal/close.svg'); ?>
                                </div>
                            </div>
                            <div class="vc-modal__success-main">
                                <div class="vc-modal__success-subtitle">
                                    <?= Loc::getMessage('REVIEW_FORM_SUCCESS_SUBTITLE'); ?>
                                </div>
                            </div>
                            <div class="vc-modal__success-footer">
                                <div class="vc-btn  js-close-modal"><?= Loc::getMessage('REVIEW_FORM_SUCCESS_BUTTON'); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <input type="hidden" name="name">
                    <div class="vc-modal__inputs">
                        <?php foreach ($arResult['PROPERTY_LIST'] as $propertyID): ?>
                        <?php $error = ($arResult['ERRORS'] && in_array($propertyID, $arResult['PROPERTY_REQUIRED']) && !(intval($propertyID) > 0 ? $arResult['ELEMENT_PROPERTIES'][$propertyID][0]['VALUE'] : $arResult['ELEMENT'][$propertyID])); ?>
                        <?php switch ($arResult['PROPERTY_LIST_FULL'][$propertyID]['PROPERTY_TYPE']) {
                            case 'E':
                                ?>
                                <input
                                        type="hidden"
                                        name="<?= 'PROPERTY['.$propertyID.'][0]'; ?>"
                                        value="<?= $arParams['DOCTOR_ID']; ?>"
                                >
                                <?php
                                break;
                            case 'S':
                            case 'N':
                                if ($propertyID == 'NAME') {
                                    ?>
                                    <input
                                            type="hidden"
                                            name="<?= 'PROPERTY[NAME][0]'; ?>"
                                            value="<?= Loc::getMessage('REVIEW_FORM_REVIEW'); ?>"
                                    >
                                    <?php
                                } elseif ($arResult['PROPERTY_LIST_FULL'][$propertyID]['CODE'] == 'GRADE') {
                                    ?>
                                    <div class="vc-record-form__score">
                                        <?php for ($i = 5; $i >= 1; $i--): ?>
                                            <label class="vc-record-form__star<?php if ($arResult['ELEMENT_PROPERTIES'][$propertyID][0]['VALUE'] == $i) echo '  vc-record-form__star--active'; ?>">
                                                <input type="radio" name="<?= 'PROPERTY['.$propertyID.'][0]'; ?>" value="<?= $i ?>" class="vc-record-form__star-input"<?php if ($arResult['ELEMENT_PROPERTIES'][$propertyID][0]['VALUE'] == $i) echo ' checked'; ?>>
                                                <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/modal/star-empty.svg'); ?>
                                            </label>
                                        <?php endfor; ?>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="vc-record-form__input-wrapper">
                                        <input
                                                type="text"
                                                name="<?= 'PROPERTY['.$propertyID.'][0]'; ?>"
                                                placeholder="<?= $arResult['PROPERTY_LIST_FULL'][$propertyID]['NAME']; ?>"
                                                class="vc-record-form__input<?php if ($error) echo '  error'; ?><?php if ($arResult['PROPERTY_LIST_FULL'][$propertyID]['CODE'] == 'PHONE') echo '  js-phone-mask'; ?>"
                                                value="<?= $arResult['ELEMENT_PROPERTIES'][$propertyID][0]['VALUE']; ?>"
                                        >
                                        <div class="vc-record-form__input-ph"><?= $arResult['PROPERTY_LIST_FULL'][$propertyID]['NAME']; ?></div>
                                    </div>
                                    <?php
                                }
                                break;
                            case 'T':
                                ?>
                                <div class="vc-record-form__input-wrapper">
                                    <textarea
                                            name="<?= 'PROPERTY['.$propertyID.'][0]'; ?>"
                                            placeholder="<?= Loc::getMessage('REVIEW_FORM_TEXTAREA'); ?>"
                                            class="vc-record-form__textarea<?php if ($error) echo '  error'; ?>"
                                    ><?= $arResult['ELEMENT'][$propertyID]; ?></textarea>
                                    <div class="vc-record-form__input-ph"><?= Loc::getMessage('REVIEW_FORM_TEXTAREA'); ?></div>
                                </div>
                            <?php
                        } ?>
                    <?php endforeach; ?>
                    </div>
                    <div class="vc-record-form__submit-wrapper">
                        <div class="vc-record-form__agreement">
                            <label class="vc-record-form__checkbox-wrapper">
                                <input type="checkbox" class="vc-record-form__checkbox" name="agreement"<?php if ($_REQUEST['agreement'] == 'on') echo '  checked'; ?>>
                                <div class="vc-record-form__checkmark">
                                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/record-form/check.svg'); ?>
                                </div>
                            </label>
                            <div class="vc-record-form__agreement-text">
                                <?= Loc::getMessage('REVIEW_FORM_AGREEMENT') ?>
                            </div>
                        </div>
                        <button type="submit" name="iblock_submit" class="vc-btn" value="Y"><?= Loc::getMessage('REVIEW_FORM_SUBMIT'); ?></button>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>
