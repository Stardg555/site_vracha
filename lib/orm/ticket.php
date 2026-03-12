<?php

namespace Vit\Doctor\ORM;

use Bitrix\Main\Type\DateTime;
use Bitrix\Main\UserTable;
use Bitrix\Iblock\Elements\{
	ElementVddoctorsTable,
	ElementVdaddressesTable,
	ElementVdservicesTable
};
use Vit\Doctor\ORM\{
	TicketStatusTable,
	TicketPatientTable
};
use Bitrix\Main\ORM\Event;
use Bitrix\Main\ORM\EventResult;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Fields\{
	IntegerField,
	StringField,
	DatetimeField,
	Relations\Reference,
	Relations\ManyToMany
};

class TicketTable extends DataManager
{
	public static function getTableName()
	{
		return 'vd_ticket';
	}
	
	public static function getMap()
	{
		return [
			(new IntegerField('ID'))
				->configurePrimary()
				->configureAutocomplete(),
			
			(new IntegerField('PATIENT_ID')),

			(new Reference('PATIENT', UserTable::class, Join::on('this.PATIENT_ID', 'ref.ID'))),

			(new IntegerField('TICKET_PATIENT_ID')),

			(new Reference('TICKET_PATIENT', TicketPatientTable::class, Join::on('this.TICKET_PATIENT_ID', 'ref.ID'))),

			(new IntegerField('DOCTOR_ID'))
				->configureRequired(),
			
			(new Reference('DOCTOR', ElementVddoctorsTable::class, Join::on('this.DOCTOR_ID', 'ref.ID'))),
				
			(new IntegerField('ADDRESS_ID')),
			
			(new Reference('ADDRESS', ElementVdaddressesTable::class, Join::on('this.ADDRESS_ID', 'ref.ID'))),
				
			(new ManyToMany('SERVICES', ElementVdservicesTable::class))
				->configureTableName('vd_ticket_service')
				->configureLocalPrimary('ID', 'TICKET_ID')
				->configureLocalReference('TICKET')
				->configureRemotePrimary('ID', 'SERVICE_ID')
				->configureRemoteReference('SERVICE'),
			
			(new DatetimeField('START_VISIT'))
				->configureRequired(),

			(new DatetimeField('END_VISIT'))
				->configureRequired(),
			
			(new IntegerField('STATUS_ID'))
				->configureRequired(),

			(new Reference('STATUS', TicketStatusTable::class, Join::on('this.STATUS_ID', 'ref.ID'))),
           
			(new DatetimeField('TIME_CREATE'))
				->configureDefaultValue(new DateTime()),

			(new DatetimeField('TIME_CHANGE'))
		];
	}

	public static function onBeforeUpdate(Event $event)
	{
	   $result = new EventResult;
	   $result->modifyFields(array('TIME_CHANGE' => new DateTime()));
	   return $result;
	}
}
