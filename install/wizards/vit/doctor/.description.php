<?php

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

if(!defined('WIZARD_DEFAULT_SITE_ID') && !empty($_REQUEST['wizardSiteID'])) {
	define('WIZARD_DEFAULT_SITE_ID', $_REQUEST['wizardSiteID']);
}

use Bitrix\Main\Localization\Loc;

$arWizardDescription = [
	'NAME' => Loc::getMessage('VIT_DOCTOR_WIZARD_NAME'),
	'DESCRIPTION' => Loc::getMessage('VIT_DOCTOR_WIZARD_DESCRIPTION'),
	'VERSION' => '1.0.0',
	'START_TYPE' => 'WINDOW',
	'WIZARD_TYPE' => 'INSTALL',
	'IMAGE' => '/images/'.LANGUAGE_ID.'/solution.png',
	'PARENT' => 'wizard_sol',
	'TEMPLATES' => [['SCRIPT' => 'scripts/template.php', 'CLASS' => 'WizardTemplate']],
	'STEPS' => (defined('WIZARD_DEFAULT_SITE_ID') ? 
		['DataInstallStep' ,'FinishStep'] : 
		['SelectSiteStep', 'DataInstallStep' ,'FinishStep'])
];