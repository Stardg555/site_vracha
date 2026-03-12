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
            <div class="vc-section__header">
                <div class="vc-section__title"><?= Loc::getMessage('VD_STAGES_TITLE'); ?></div>
            </div>
            <div class="vc-section__content">
                <div class="vc-multi-blocks">
                    <div class="vc-multi-blocks__main">
                        <?php foreach ($arResult['ITEMS'] as $key => $arItem): ?>
                            <?php
                            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
                            ?>
                            <div class="vc-multi-blocks__item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                                <div class="vc-multi-blocks__item-header">
                                    <div class="vc-multi-blocks__item-marker"><?= $key + 1; ?></div>
                                    <div class="vc-multi-blocks__item-title"><?= $arItem['NAME']; ?></div>
                                </div>
                                <div class="vc-multi-blocks__item-content">
                                    <div class="vc-multi-blocks__item-text"><?= $arItem['DETAIL_TEXT']; ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
