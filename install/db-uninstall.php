<?php

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;

$arSql = [
    'DROP TABLE IF EXISTS `vd_schedule`;',
    'DROP TABLE IF EXISTS `vd_ticket`;',
    'DROP TABLE IF EXISTS `vd_ticket_patient`;',
    'DROP TABLE IF EXISTS `vd_ticket_service`;',
    'DROP TABLE IF EXISTS `vd_ticket_status`;',
];

$connection = Application::getConnection();
foreach ($arSql as $sql) {
    $connection->queryExecute($sql);
}
