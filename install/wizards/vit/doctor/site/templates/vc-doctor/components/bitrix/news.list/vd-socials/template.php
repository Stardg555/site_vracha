<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>

<?php if ($arResult['ITEMS']): ?>
    <div class="vc-branches__contact">
        <div class="vc-branches__socials">
            <?php foreach($arResult['ITEMS'] as $arItem): ?>
                <?php
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
                ?>
                <a href="<?= $arItem['DISPLAY_PROPERTIES']['LINK']['VALUE']; ?>"  target="_blank" class="vc-branches__social  vc-branches__social--<?= $arItem['DISPLAY_PROPERTIES']['SOCIAL']['VALUE_XML_ID']; ?>" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/socials/'.$arItem['DISPLAY_PROPERTIES']['SOCIAL']['VALUE_XML_ID'].'.svg'); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
