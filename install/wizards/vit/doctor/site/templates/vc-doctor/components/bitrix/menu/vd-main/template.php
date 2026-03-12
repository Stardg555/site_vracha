<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$this->setFrameMode(true);
?>

<?php if (!empty($arResult)): ?>
    <div class="vc-menu">
        <?php foreach ($arResult as $arItem):
            if ($arParams['MAX_LEVEL'] == 1 && $arItem['DEPTH_LEVEL'] > 1) {
                continue;
            } ?>
                
            <div class="vc-menu__item<?= ($arItem['SELECTED'] ? '  vc-menu__item--active' : ''); ?>">
                <div class="vc-menu__item-header">
                    <a href="<?= $arItem['LINK']; ?>" class="vc-menu__item-title"><?= $arItem['TEXT']; ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
