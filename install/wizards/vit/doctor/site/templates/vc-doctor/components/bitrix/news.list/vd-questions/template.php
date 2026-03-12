<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>

<?php if ($arResult['ITEMS']): ?>
    <div class="vc-section"  id="faq">
        <div class="vc-center">
            <div class="vc-section__header">
                <div class="vc-section__title"><?= Loc::getMessage('VD_QUESTIONS_TITLE'); ?></div>
            </div>
            <div class="vc-section__content">
                <div class="vc-spoilers">
                    <div class="vc-spoilers__main">
                        <div class="vc-spoilers__list">
                            <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                                <?php
                                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
                                ?>
                                <div class="vc-spoilers__item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                                    <div class="vc-spoilers__item-header">
                                        <div class="vc-spoilers__item-icon">
                                            <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/spoilers/arrow-bottom.svg'); ?>
                                        </div>
                                        <div class="vc-spoilers__item-title">
                                            <?= $arItem['NAME']; ?>
                                        </div>
                                    </div>
                                    <div class="vc-spoilers__item-content">
                                        <div class="vc-spoilers__item-text  vc-visual-editor">
                                            <?= $arItem['DETAIL_TEXT']; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
