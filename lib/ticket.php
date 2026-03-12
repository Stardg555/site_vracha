<?php

namespace Vit\Doctor;

use Bitrix\Main\{
    Application,
    Type\DateTime,
    Localization\Loc
};
use Bitrix\Iblock\Elements\ElementVdservicesTable;
use Vit\Doctor\{
    ORM\TicketTable,
    ORM\TicketStatusTable
};

class Ticket
{
    const RESERVATION_TIME_MIN = 5;
    public static array $arRecordError = [];

    public static function getStatusIdByCode(string $code) : ?int {
        return TicketStatusTable::getList([
            'select' => ['ID'],
            'filter' => ['CODE' => $code]
        ])->fetch()['ID'];
    }

    public static function removeReservedAgent() : string {
        $reservationDateTime = (new DateTime())->add('-'.self::RESERVATION_TIME_MIN.' minutes');

        $tickets = TicketTable::getList([
            'filter' => ['STATUS.CODE' => 'reserved', '<TIME_CREATE' => $reservationDateTime]
        ])->fetchCollection();

        foreach($tickets as $ticket) {
            $ticket->removeAllServices();
            $ticket->delete();
        }

        return "Vit\ClinicPro\Ticket::removeReservedAgent();";
    }
}
