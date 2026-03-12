<?php

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;

$arSql = [
    'DROP TABLE IF EXISTS `vd_schedule`;',
    '
    CREATE TABLE `vd_schedule` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `DOCTOR_ID` int(11) NOT NULL,
    `ADDRESS_ID` int(11) NOT NULL,
    `START_PERIOD` datetime NOT NULL,
    `END_PERIOD` datetime NOT NULL,
    `DURATION` int(11) NOT NULL,
    PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ',
    'DROP TABLE IF EXISTS `vd_ticket`;',
    '
    CREATE TABLE `vd_ticket` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `PATIENT_ID` int(11) DEFAULT NULL,
    `TICKET_PATIENT_ID` int(11) DEFAULT NULL,
    `DOCTOR_ID` int(11) NOT NULL,
    `ADDRESS_ID` int(11) NOT NULL,
    `START_VISIT` datetime NOT NULL,
    `END_VISIT` datetime NOT NULL,
    `STATUS_ID` int(11) NOT NULL,
    `TIME_CREATE` datetime NOT NULL,
    `TIME_CHANGE` datetime DEFAULT NULL,
    PRIMARY KEY (`ID`),
    KEY `PATIENT_ID` (`PATIENT_ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ',
    'DROP TABLE IF EXISTS `vd_ticket_patient`;',
    '
    CREATE TABLE `vd_ticket_patient` (
    `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `LAST_NAME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `NAME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `SECOND_NAME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `PHONE` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ',
    'DROP TABLE IF EXISTS `vd_ticket_service`;',
    '
    CREATE TABLE `vd_ticket_service` (
    `TICKET_ID` int(11) unsigned NOT NULL,
    `SERVICE_ID` int(11) unsigned NOT NULL,
    KEY `TICKET_ID` (`TICKET_ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ',
    'DROP TABLE IF EXISTS `vd_ticket_status`;',
    '
    CREATE TABLE `vd_ticket_status` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `NAME` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (`ID`),
    UNIQUE KEY `CODE` (`CODE`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    '
];

$arSql[] = Loc::getMessage('VD_TICKET_STATUS');

$connection = Application::getConnection();
foreach ($arSql as $sql) {
    $connection->queryExecute($sql);
}
