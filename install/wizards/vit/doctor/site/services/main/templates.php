<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

$bitrixTemplateDir = $_SERVER['DOCUMENT_ROOT'].BX_PERSONAL_ROOT.'/templates/';

CopyDirFiles(
	$_SERVER['DOCUMENT_ROOT'].WizardServices::GetTemplatesPath(WIZARD_RELATIVE_PATH.'/site').'/',
	$bitrixTemplateDir,
	$rewrite = true,
	$recursive = true,
	$delete_after_copy = false
);

$obSite = CSite::GetList($by = 'def', $order = 'desc', ['LID' => WIZARD_SITE_ID]);
if ($arSite = $obSite->Fetch()) {
	$arTemplates = [];
	$foundDoctor = false;
	$obTemplate = CSite::GetTemplateList($arSite['LID']);
	while($arTemplate = $obTemplate->Fetch()) {
		if (!$foundDoctor && $arTemplate['CONDITION'] == '') {
			$arTemplate['TEMPLATE'] = 'vc-doctor';
			$foundDoctor = true;
		}
		$arTemplates[] = $arTemplate;
	}

	if (!$foundDoctor) {
		$arTemplates[] = ['CONDITION' => '', 'SORT' => 10, 'TEMPLATE' => 'vc-doctor'];
	}
		
	$arFields = [
		'TEMPLATE' => $arTemplates,
		'NAME' => $arSite['NAME'],
	];

	$obSite = new CSite();
	$obSite->Update($arSite['LID'], $arFields);
}
