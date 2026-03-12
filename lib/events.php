<?php

namespace Vit\Doctor;

use Bitrix\Main\Context;
use Bitrix\Main\Mail\Event;
use Bitrix\Main\Localization\Loc;

class Events
{
    public static function checkForBot(&$arFields)
    {
        $callbackIblockId = Helper::getIblockIdByCode('vd-callback');
        $reviewsIblockId = Helper::getIblockIdByCode('vd-reviews');
        $doctorHomeIblockId = Helper::getIblockIdByCode('vd-doctor-home');

        if (in_array($arFields['IBLOCK_ID'], [$callbackIblockId, $reviewsIblockId, $doctorHomeIblockId])) {
            $request = Context::getCurrent()->getRequest();
            if (!empty($request->get('phone')) || !empty($request->get('email'))) {
                global $APPLICATION;
                $APPLICATION->throwException(Loc::getMessage('VD_CHECK_FOR_BOT_MESSAGE'));
                return false;
            }
        }
    }
    
    public static function onAfterCallbackFormSend($arFields)
    {
        $callbackIblockId = Helper::getIblockIdByCode('vd-callback');
        if ($arFields['ID'] > 0 && $arFields['IBLOCK_ID'] == $callbackIblockId) {
            $namePropId = Helper::getPropertyIdByCode($callbackIblockId, 'NAME');
            $phonePropId = Helper::getPropertyIdByCode($callbackIblockId, 'PHONE');

            $res = \CUser::GetByID(1);
            $user = $res->Fetch();
            $cFields = ['EMAIL' => $user['EMAIL']];

            if ($arFields['PROPERTY_VALUES'][$namePropId]) {
                $cFields['NAME'] = $arFields['PROPERTY_VALUES'][$namePropId];
            }
            if ($arFields['PROPERTY_VALUES'][$phonePropId]) {
                $cFields['PHONE'] = $arFields['PROPERTY_VALUES'][$phonePropId];
            }

            $res = \CSite::GetList($by = 'id', $order = 'asc', ['ACTIVE' => 'Y']);
            while ($el = $res->Fetch()) {
                $sites[] = $el['LID'];
            }

            Event::send([
                'EVENT_NAME' => 'VD_FORM_CALLBACK',
                'LID' => implode(',', $sites),
                'C_FIELDS' => $cFields
            ]);
        }
    }

    public static function onBeforeReviewFormSend(&$arFields)
    {
        $reviewsIblockId = Helper::getIblockIdByCode('vd-reviews');
        if ($arFields['IBLOCK_ID'] == $reviewsIblockId) {
            $arFields['ACTIVE'] = "N";
        }
    }

    public static function onAfterReviewFormSend($arFields)
    {
        $reviewsIblockId = Helper::getIblockIdByCode('vd-reviews');
        if ($arFields['ID'] > 0 && $arFields['IBLOCK_ID'] == $reviewsIblockId) {
            $gradePropId = Helper::getPropertyIdByCode($reviewsIblockId, 'GRADE');
            $namePropId = Helper::getPropertyIdByCode($reviewsIblockId, 'NAME');
            $mailPropId = Helper::getPropertyIdByCode($reviewsIblockId, 'MAIL');

            $res = \CUser::GetByID(1);
            $user = $res->Fetch();
            $cFields = ['EMAIL' => $user['EMAIL']];

            if ($arFields['PROPERTY_VALUES'][$gradePropId]) {
                $cFields['GRADE'] = $arFields['PROPERTY_VALUES'][$gradePropId];
            }
            if ($arFields['PROPERTY_VALUES'][$namePropId]) {
                $cFields['NAME'] = $arFields['PROPERTY_VALUES'][$namePropId];
            }
            if ($arFields['PROPERTY_VALUES'][$mailPropId]) {
                $cFields['MAIL'] = $arFields['PROPERTY_VALUES'][$mailPropId];
            }
            if ($arFields['DETAIL_TEXT']) {
                $cFields['TEXT'] = $arFields['DETAIL_TEXT'];
            }

            $res = \CSite::GetList($by = 'id', $order = 'asc', ['ACTIVE' => 'Y']);
            while ($el = $res->Fetch()) {
                $sites[] = $el['LID'];
            }

            Event::send([
                'EVENT_NAME' => 'VD_FORM_REVIEW',
                'LID' => implode(',', $sites),
                'C_FIELDS' => $cFields
            ]);
        }
    }
   
    public static function onAfterDoctorHomeFormSend($arFields)
    {
        $doctorHomeIblockId = Helper::getIblockIdByCode('vd-doctor-home');
        if ($arFields['ID'] > 0 && $arFields['IBLOCK_ID'] == $doctorHomeIblockId) {
            $namePropId = Helper::getPropertyIdByCode($doctorHomeIblockId, 'NAME');
            $phonePropId = Helper::getPropertyIdByCode($doctorHomeIblockId, 'PHONE');
            $addressPropId = Helper::getPropertyIdByCode($doctorHomeIblockId, 'ADDRESS');

            $res = \CUser::GetByID(1);
            $user = $res->Fetch();
            $cFields = ['EMAIL' => $user['EMAIL']];

            if ($arFields['PROPERTY_VALUES'][$namePropId]) {
                $cFields['NAME'] = $arFields['PROPERTY_VALUES'][$namePropId];
            }
            if ($arFields['PROPERTY_VALUES'][$phonePropId]) {
                $cFields['PHONE'] = $arFields['PROPERTY_VALUES'][$phonePropId];
            }
            if ($arFields['PROPERTY_VALUES'][$addressPropId]) {
                $cFields['ADDRESS'] = $arFields['PROPERTY_VALUES'][$addressPropId];
            }
            if ($arFields['DETAIL_TEXT']) {
                $cFields['TEXT'] = $arFields['DETAIL_TEXT'];
            }

            $res = \CSite::GetList($by = 'id', $order = 'asc', ['ACTIVE' => 'Y']);
            while ($el = $res->Fetch()) {
                $sites[] = $el['LID'];
            }

            Event::send([
                'EVENT_NAME' => 'VD_FORM_DOCTOR_HOME',
                'LID' => implode(',', $sites),
                'C_FIELDS' => $cFields
            ]);
        }
    }
    
    public static function page404()
    {
        if(defined('ERROR_404') && ERROR_404 == 'Y' && !defined('ADMIN_SECTION')) {
            global $APPLICATION;
            $APPLICATION->RestartBuffer();
            \CHTTP::setStatus('404 Not Found');
            include($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/header.php');
            require($_SERVER['DOCUMENT_ROOT'].'/404.php');
            include($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/footer.php');
        }
    }
}