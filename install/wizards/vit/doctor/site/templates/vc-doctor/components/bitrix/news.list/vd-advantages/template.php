<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>

<?php if ($arResult['ITEMS']): ?>
    <div class="vc-home-bnr__stats">
        <?php foreach ($arResult['ITEMS'] as $arItem): ?>
            <?php
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
            ?>
            <div class="vc-home-bnr__stat" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                <div class="vc-home-bnr__stat-icon">
                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].$arItem['DISPLAY_PROPERTIES']['ICON']['FILE_VALUE']['SRC']); ?>
                </div>
                <div class="vc-home-bnr__stat-title"><?= $arItem['DETAIL_TEXT']; ?></div>
                <div class="vc-home-bnr__stat-text"><?= $arItem['NAME']; ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
