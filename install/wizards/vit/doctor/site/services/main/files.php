<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

if (!defined('WIZARD_SITE_ID')) {
	return;
}

if (!defined('WIZARD_SITE_DIR')) {
	return;
}
 
$path = str_replace('//', '/', WIZARD_ABSOLUTE_PATH.'/site/public/'.LANGUAGE_ID.'/'); 

$handle = @opendir($path);
if ($handle) {
	while ($file = readdir($handle)) {
		if (in_array($file, array('.', '..'))) {
			continue;
		}
 
		CopyDirFiles(
			$path.$file,
			WIZARD_SITE_PATH.'/'.$file,
			$rewrite = true, 
			$recursive = true,
			$delete_after_copy = false
		);
	}

	CModule::IncludeModule('search');
	CSearch::ReIndexAll(false, 0, [WIZARD_SITE_ID, WIZARD_SITE_DIR]);
}

WizardServices::PatchHtaccess(WIZARD_SITE_PATH);

$arDirectories = ['includes'];
foreach ($arDirectories as $directory) {
	WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH.$directory.'/', ['SITE_DIR' => WIZARD_SITE_DIR]);
}
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'_index.php', ['SITE_DIR' => WIZARD_SITE_DIR]);
