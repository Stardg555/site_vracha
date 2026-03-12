<?php

use Vit\Doctor\{
    Settings,
    EventManager
};
use Bitrix\Main\Localization\Loc;

EventManager::run();
$GLOBALS['VD_SETTINGS'] = Settings::getAll(true);

$access = $GLOBALS['APPLICATION']->GetGroupRight('vit.doctor');
if ($access < 'R') {
    $GLOBALS['APPLICATION']->AddPanelButton([
        'HREF' => '/bitrix/admin/wizard_install.php?lang='.LANGUAGE_ID.'&wizardName=vit:doctor&'.bitrix_sessid_get(),
        'ALT' => Loc::getMessage('VIT_DOCTOR_WIZARD_BUTTON_DESCRIPTION'),
        'MAIN_SORT' => 2500,
        'SORT' => 10,
        'TYPE' => 'BIG',
        'ICON' => 'bx-panel-site-wizard-icon',
        'TEXT' => Loc::getMessage('VIT_DOCTOR_WIZARD_BUTTON_NAME')
    ]);
}
