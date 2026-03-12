<?php

use Vit\Doctor\Helper;
use Bitrix\Main\{
    Loader,
    Application,
    HttpApplication,
    Config\Option,
    Localization\Loc
};
use Bitrix\Iblock\Elements\ElementVddoctorsTable;

$request = HttpApplication::getInstance()->getContext()->getRequest();

$module_id = htmlspecialcharsbx($request['mid'] != '' ? $request['mid'] : $request['id']);

$access = $APPLICATION->GetGroupRight($module_id);
if ($access < 'R') {
	return;
}

Loader::includeModule($module_id);
Loader::includeModule('iblock');

Loc::loadMessages(__FILE__);

$arDoctors = [];
if (Helper::getIblockIdByCode('vd-doctors')) {
    $doctors =  ElementVddoctorsTable::getList([
        'select' => ['ID', 'NAME'],
        'order' => ['SORT']
    ]);
    while ($arDoctor = $doctors->fetch()) {
        $arDoctors[$arDoctor['ID']] = $arDoctor['NAME'];
    }
}

$arTabs = [
    [
        'DIV' => 'design',
        'TAB' => Loc::getMessage('MAIN_TAB_DESIGN'),
        'TITLE' => Loc::getMessage('MAIN_TAB_TITLE_DESIGN'),
        'OPTIONS' => [
            [
                'main_color',
                Loc::getMessage('VIT_DOCTOR_DESIGN_MAIN_COLOR'),
                '',
                ['text', 10]
            ]
        ]
    ],
    [
        'DIV' => 'settings',
        'TAB' => Loc::getMessage('MAIN_TAB_SET'),
        'TITLE' => Loc::getMessage("MAIN_TAB_TITLE_SET"),
        'OPTIONS' => [
            [
                'doctor',
                Loc::getMessage('VIT_DOCTOR'),
                '',
                [
                    'selectbox',
                    $arDoctors
                ]
            ],
            [
                'meta',
                Loc::getMessage('VIT_DOCTOR_META_TITLE'),
                '',
                ['textarea', 10, 50]
            ],
            [
                'counters',
                Loc::getMessage('VIT_DOCTOR_COUNTERS_TITLE'),
                '',
                ['textarea', 10, 50]
            ]
        ]
    ],
    [
        'DIV' => 'rights',
        'TAB' => Loc::getMessage('MAIN_TAB_RIGHTS'),
        'TITLE' => Loc::getMessage('MAIN_TAB_TITLE_RIGHTS')
    ]
];

$tabControl = new CAdminTabControl('tabControl', $arTabs);

if ($request->isPost() && $request->getPost('Update') && check_bitrix_sessid() && $access == 'W') {
    foreach ($arTabs as $arTab) {
        __AdmSettingsSaveOptions($module_id, $arTab['OPTIONS']);
    }

	ob_start();
	require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/admin/group_rights.php');
	ob_end_clean();

    LocalRedirect($APPLICATION->GetCurPage().'?mid='.$module_id.'&lang='.LANGUAGE_ID.'&mid_menu=1&'.$tabControl->ActiveTabParam());
}
?>

<form action="<?= $APPLICATION->GetCurPage().'?mid='.$module_id.'&lang='.LANGUAGE_ID.'&mid_menu=1'; ?>" method='post'>
    <?php
    $tabControl->Begin();
    echo bitrix_sessid_post();
    foreach ($arTabs as $arTab) {
        if ($arTab['OPTIONS']) {
            $tabControl->BeginNextTab();
            __AdmSettingsDrawList($module_id, $arTab['OPTIONS']);
        }
    }
    $tabControl->BeginNextTab();
    require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/admin/group_rights.php');
    $tabControl->Buttons();
    ?><input type="submit" name="Update" value="<?= Loc::getMessage('MAIN_SAVE') ?>" class="adm-btn-save" <?= ($access != 'W' ? '  disabled' : ''); ?>><?php
    $tabControl->End();
    ?>
</form>

<script>
    document.querySelector('input[name=main_color]').type = 'color';
</script>