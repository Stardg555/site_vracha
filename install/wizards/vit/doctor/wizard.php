<?php

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/install/wizard_sol/wizard.php');

use Bitrix\Main\Localization\Loc;

class SelectSiteStep extends CSelectSiteWizardStep
{
	function InitStep() {
		parent::InitStep();
		$wizard = &$this->GetWizard();
		$wizard->solutionName = 'doctor';
		$this->SetNextStep('data_install');
		$this->SetNextCaption(Loc::getMessage('wiz_install'));
	}
}

class DataInstallStep extends CDataInstallWizardStep {}

class FinishStep extends CFinishWizardStep {}
?>