<?php

namespace Vit\Doctor\ORM;

use Vit\Doctor\ORM\TicketTable;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\{
	IntegerField,
	StringField,
    DateField,
	Relations\OneToMany
};

class TicketPatientTable extends DataManager
{
	public static function getTableName()
	{
		return 'vd_ticket_patient';
	}

    public static function getMap()
    {
        return [
			(new IntegerField('ID'))
				->configurePrimary()
				->configureAutocomplete(),

            (new StringField('LAST_NAME'))
                ->configureRequired(),

            (new StringField('NAME'))
                ->configureRequired(),

            (new StringField('SECOND_NAME'))
                ->configureRequired(),

            (new StringField('PHONE'))
                ->configureRequired(),

            (new OneToMany('TICKETS', TicketTable::class, 'TICKET_PATIENT'))
        ];
    }
}
