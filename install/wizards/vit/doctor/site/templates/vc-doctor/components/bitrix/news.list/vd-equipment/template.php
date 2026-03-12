<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>

<?php if ($arResult['ITEMS']): ?>
    <div class="vc-section  vc-section--p32" id="equipment">
        <div class="vc-center">
            <div class="vc-section__header">
                <div class="vc-section__title"><?= Loc::getMessage('VD_EQUIPMENT_TITLE'); ?></div>
            </div>
            <div class="vc-section__content">
                <div class="vc-mirror">
                    <div class="vc-mirror__main  vc-visual-editor">
                        <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                            <?php
                            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
                            ?>
                            <div class="vc-mirror__item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                                <h3><?= $arItem['NAME']; ?></h3>
                                <div class="vc-mirror__item-image">
                                    <img src="<?= $arItem['DETAIL_PICTURE']['RESIZED']['src']; ?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT']; ?>" class="vc-mirror__item-image-img">
                                </div>
                                <div class="vc-mirror__item-content">
                                    <?= $arItem['DETAIL_TEXT']; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
