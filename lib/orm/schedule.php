<?php

namespace Vit\Doctor\ORM;

use Bitrix\Iblock\Elements\{
    ElementVddoctorsTable,
    ElementVdaddressesTable
};
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Fields\{
	IntegerField,
    DatetimeField,
    Relations\Reference
};

class ScheduleTable extends DataManager
{
	public static function getTableName()
	{
		return 'vd_schedule';
	}

    public static function getMap()
    {
        return [
			(new IntegerField('ID'))
				->configurePrimary()
				->configureAutocomplete(),
            
			(new IntegerField('DOCTOR_ID'))
				->configureRequired(),

            (new Reference('DOCTOR', ElementVddoctorsTable::class, Join::on('this.DOCTOR_ID', 'ref.ID'))),

			(new IntegerField('ADDRESS_ID'))
				->configureRequired(), 

            (new Reference('ADDRESS', ElementVdaddressesTable::class, Join::on('this.ADDRESS_ID', 'ref.ID'))),

            (new DatetimeField('START_PERIOD'))
                ->configureRequired(),

            (new DatetimeField('END_PERIOD'))
                ->configureRequired(),

            (new IntegerField('DURATION'))
                ->configureRequired()
        ];
    }
}
