<?php

namespace Vit\Doctor;

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\DateTime;
use Bitrix\Iblock\Elements\ElementVddoctorsTable;
use Bitrix\Iblock\Elements\ElementVdaddressesTable;
use Vit\Doctor\ORM\ScheduleTable;

Loader::includeModule('iblock');

class Schedule
{
    public static function __seedData()
    {
        if (
            $r = ElementVddoctorsTable::getList([
                'select' => ['ID', 'ADDRESS_ID' => 'ADDRESS.ELEMENT.ID'],
                'filter' => ['ACTIVE' => 'Y', 'ADDRESS.ELEMENT.ACTIVE' => 'Y'],
                'order' => ['NAME']
            ])->fetchAll()
        ) {
            foreach (new \DatePeriod(new \DateTime('now'), new \DateInterval('P1D'), new \DateTime('+2 month'), 1) as $obDate) {
                $arDates[] = $obDate->format('d.m.Y');
            }
            
            foreach ($r as $i) {
                foreach ($arDates as $date) {
                    if (rand(0, 1)) {
                        $timePeriod = [
                            '08:00:00 - 10:00:00',
                            '11:00:00 - 13:00:00',
                            '14:00:00 - 16:00:00',
                        ][rand(0, 2)];
                        $arSchedule[$i['ID']][$date][$timePeriod] = $i['ADDRESS_ID'];
                    }
                }
            }
            unset($arDates, $date, $timePeriod);
                      
            Application::getConnection()->truncateTable(ScheduleTable::getTableName());

            foreach ($arSchedule as $doctorId => $arDates) {
                foreach ($arDates as $date => $arTimePeriods) {
                    foreach ($arTimePeriods as $timePeriod => $branchId) {
                        $arTimePeriod = explode(' - ', $timePeriod);

                        ScheduleTable::add([
                            'DOCTOR_ID' => $doctorId,
                            'ADDRESS_ID' => $branchId,
                            'START_PERIOD' => new DateTime($date.' '.$arTimePeriod[0]),
                            'END_PERIOD' => new DateTime($date.' '.$arTimePeriod[1]),
                            'DURATION' => [600, 1200, 1800][rand(0, 2)]
                        ]);
                    }
                }
            }

            return true;
        }
    }
}
