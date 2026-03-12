<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use Bitrix\Main\Localization\Loc;

$arServices = [
	'main' => [
		'NAME' => Loc::getMessage('VIT_DOCTOR_SERVICE_MAIN_SETTINGS'),
		'STAGES' => [
			'files.php',
			'templates.php',
			'mails.php'
		]
	],
	'iblock' => [
		'NAME' => Loc::getMessage('VIT_DOCTOR_SERVICE_IBLOCK'),
		'STAGES' => [
			'types.php',
			'vd-questions.php',
			'vd-stages.php',
			'vd-reviews.php',
			'vd-certificates.php',
			'vd-equipment.php',
			'vd-results.php',
			'vd-gallery.php',
			'vd-socials.php',
			'vd-advantages.php',
			'vd-callback.php',
			'vd-doctor-home.php',
			'vd-specialties.php',
			'vd-addresses.php',
			'vd-services.php',
			'vd-doctors.php'
		]
	],
	'vit.doctor' => [
		'NAME' => Loc::getMessage('VIT_DOCTOR_SERVICE_ADDITIONAL_SETTINGS'),
		'STAGES' => [
			'vdp.php'
		]
	]
];
?>