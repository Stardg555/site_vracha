<?php

namespace Vit\Doctor;

class EventManager
{
    public static function run()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandler('iblock', 'OnBeforeIBlockElementAdd', 'vit.doctor', '\\Vit\\Doctor\\Events', 'checkForBot');
        $eventManager->registerEventHandler('iblock', 'OnBeforeIBlockElementAdd', 'vit.doctor', '\\Vit\\Doctor\\Events', 'onBeforeReviewFormSend');
        $eventManager->registerEventHandler('iblock', 'OnAfterIBlockElementAdd', 'vit.doctor', '\\Vit\\Doctor\\Events', 'onAfterCallbackFormSend');
        $eventManager->registerEventHandler('iblock', 'OnAfterIBlockElementAdd', 'vit.doctor', '\\Vit\\Doctor\\Events', 'onAfterReviewFormSend');
        $eventManager->registerEventHandler('iblock', 'OnAfterIBlockElementAdd', 'vit.doctor', '\\Vit\\Doctor\\Events', 'onAfterDoctorHomeFormSend');
        $eventManager->registerEventHandler('main', 'OnEpilog', 'vit.doctor', '\\Vit\\Doctor\\Events', 'page404');
        $eventManager->registerEventHandler('iblock', 'OnIBlockPropertyBuildList', 'vit.doctor', '\\Vit\\Doctor\\UserType\\WorkTime', 'GetUserTypeDescription');
    }
}
