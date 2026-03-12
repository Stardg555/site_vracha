<?php

namespace Vit\Doctor\ORM;

use Vit\Doctor\ORM\TicketTable;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\{
	IntegerField,
	StringField,
	Relations\OneToMany
};

class TicketStatusTable extends DataManager
{
	public static function getTableName()
	{
		return 'vd_ticket_status';
	}

    public static function getMap()
    {
        return [
			(new IntegerField('ID'))
				->configurePrimary()
				->configureAutocomplete(),

            (new StringField('NAME'))
                ->configureRequired(),

            (new StringField('CODE'))
                ->configureRequired()
                ->configureUnique(),

            (new OneToMany('TICKETS', TicketTable::class, 'STATUS'))
        ];
    }
}
