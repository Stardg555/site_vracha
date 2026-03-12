<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use \Bitrix\Main\Localization\Loc;

$this->setFrameMode(false);
?>

<div class="vc-modal  vc-modal--small"  data-name="callbackModal">
    <div class="vc-modal__container">
        <div class="vc-modal__header">
            <div class="vc-modal__title-wrapper">
                <div class="vc-modal__title">
                    <?= Loc::getMessage('CALLBACK_MODAL_TITLE'); ?>
                </div>
                <div class="vc-modal__close-wrapper">
                    <div class="vc-modal__close">
                        <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/modal/close.svg'); ?>
                    </div>
                </div>
            </div>
            <div class="vc-modal__subtitle">
                <?= Loc::getMessage('CALLBACK_MODAL_SUBTITLE'); ?>
            </div>
        </div>
        <div class="vc-modal__content">
            <div class="vc-record-form">
                <form class="vc-record-form__form  js-record-form" id="callback-modal-form" action="<?= POST_FORM_ACTION_URI; ?>" method="post" enctype="multipart/form-data">
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
                                    <?= Loc::getMessage('CALLBACK_MODAL_SUCCESS_SUBTITLE'); ?>
                                </div>
                            </div>
                            <div class="vc-modal__success-footer">
                                <div class="vc-btn  js-close-modal"><?= Loc::getMessage('CALLBACK_MODAL_SUCCESS_BUTTON'); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="vc-modal__inputs">
                        <input type="hidden" name="name">
                        <?php foreach ($arResult['PROPERTY_LIST'] as $propertyID): ?>
                            <?php $error = ($arResult['ERRORS'] && in_array($propertyID, $arResult['PROPERTY_REQUIRED']) && !(intval($propertyID) > 0 ? $arResult['ELEMENT_PROPERTIES'][$propertyID][0]['VALUE'] : $arResult['ELEMENT'][$propertyID])); ?>
                            <?php switch ($arResult['PROPERTY_LIST_FULL'][$propertyID]['PROPERTY_TYPE']) {
                                case 'S':
                                case 'N':
                                    if ($propertyID == 'NAME') {
                                        ?>
                                        <input
                                                type="hidden"
                                                name="<?= 'PROPERTY[NAME][0]'; ?>"
                                                value="<?= Loc::getMessage('CALLBACK_MODAL_CALLBACK'); ?>"
                                        >
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
                                <?= Loc::getMessage('CALLBACK_MODAL_AGREEMENT'); ?>
                            </div>
                        </div>
                        <button type="submit" name="iblock_submit" class="vc-btn" value="Y"><?= Loc::getMessage('CALLBACK_MODAL_SUBMIT'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
