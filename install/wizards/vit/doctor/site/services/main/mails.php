<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

if (!defined('WIZARD_SITE_ID')) {
	return;
}

use Bitrix\Main\Localization\Loc;

$obEventType = new CEventType;
$obEventMessage = new CEventMessage;

$res = $obEventType->Add([
    'LID' => LANGUAGE_ID,
    'EVENT_NAME' => 'VD_FORM_CALLBACK',
    'EVENT_TYPE' => 'email',
    'NAME' => Loc::getMessage('VD_FORM_CALLBACK_EVENT_NAME'),
    'DESCRIPTION' => Loc::getMessage('VD_FORM_CALLBACK_EVENT_DESCRIPTION')
]);
if ($res) {
    $obEventMessage->Add([
        'ACTIVE' => 'Y',
        'EVENT_NAME' => 'VD_FORM_CALLBACK',
        'LID' => WIZARD_SITE_ID,
        'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
        'EMAIL_TO' => '#EMAIL#',
        'SUBJECT' => Loc::getMessage('VD_FORM_CALLBACK_MESSAGE_SUBJECT'),
        'BODY_TYPE' => 'text',
        'MESSAGE' => Loc::getMessage('VD_FORM_CALLBACK_MESSAGE_TEXT')
    ]);
}

$res = $obEventType->Add([
    'LID' => LANGUAGE_ID,
    'EVENT_NAME' => 'VD_FORM_REVIEW',
    'EVENT_TYPE' => 'email',
    'NAME' => Loc::getMessage('VD_FORM_REVIEW_EVENT_NAME'),
    'DESCRIPTION' => Loc::getMessage('VD_FORM_REVIEW_EVENT_DESCRIPTION')
]);
if($res) {
    $obEventMessage->Add([
        'ACTIVE' => 'Y',
        'EVENT_NAME' => 'VD_FORM_REVIEW',
        'LID' => WIZARD_SITE_ID,
        'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
        'EMAIL_TO' => '#EMAIL#',
        'SUBJECT' => Loc::getMessage('VD_FORM_REVIEW_MESSAGE_SUBJECT'),
        'BODY_TYPE' => 'text',
        'MESSAGE' => Loc::getMessage('VD_FORM_REVIEW_MESSAGE_TEXT')
    ]);
}

$res = $obEventType->Add([
    'LID' => LANGUAGE_ID,
    'EVENT_NAME' => 'VD_FORM_DOCTOR_HOME',
    'EVENT_TYPE' => 'email',
    'NAME' => Loc::getMessage('VD_FORM_DOCTOR_HOME_EVENT_NAME'),
    'DESCRIPTION' => Loc::getMessage('VD_FORM_DOCTOR_HOME_EVENT_DESCRIPTION')
]);
if ($res) {
    $obEventMessage->Add([
        'ACTIVE' => 'Y',
        'EVENT_NAME' => 'VD_FORM_DOCTOR_HOME',
        'LID' => WIZARD_SITE_ID,
        'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
        'EMAIL_TO' => '#EMAIL#',
        'SUBJECT' => Loc::getMessage('VD_FORM_DOCTOR_HOME_MESSAGE_SUBJECT'),
        'BODY_TYPE' => 'text',
        'MESSAGE' => Loc::getMessage('VD_FORM_DOCTOR_HOME_MESSAGE_TEXT')
    ]);
}
