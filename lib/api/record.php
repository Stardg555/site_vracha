<?php

namespace Vit\Doctor\API;

use Bitrix\Main\Application;
use Bitrix\Main\Web\Uri;
use Bitrix\Main\Loader;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Error;
use Bitrix\Main\Context;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Main\Localization\Loc;
use Bitrix\Iblock\Elements\ElementVddoctorsTable;
use Bitrix\Iblock\Elements\ElementVdservicesTable;
use Bitrix\Iblock\Elements\ElementVdaddressesTable;
use Bitrix\Main\ORM\Fields\ExpressionField;
use Vit\Doctor\Helper;
use Vit\Doctor\Schedule;
use Vit\Doctor\ORM\TicketTable;
use Vit\Doctor\ORM\TicketStatusTable;
use Vit\Doctor\ORM\TicketPatientTable;
use Vit\Doctor\ORM\ScheduleTable;
use Vit\Doctor\Ticket;

Loader::includeModule('iblock');

class Record extends Controller
{
	public function configureActions()
	{
		return [
			'getSchedule' => [
				'prefilters' => [],
				'postfilters' => [],
			],
			'block' => [
				'prefilters' => [],
				'postfilters' => [],
			],
			'unblock' => [
				'prefilters' => [],
				'postfilters' => [],
			],
			'confirm' => [
				'prefilters' => [],
				'postfilters' => [],
			],
		];
	}

	public function getScheduleAction($searchString = null, $specId = null, $servId = null, $depId = null, $docId = null, $date = null, $page = null)
	{
		$arSchedule['DOCTORS'] = [];
		$arFilter = [];
		$arDoctorIds = [];
		$arBranchIds = [];
		$arServiceIds = [];



		if ($searchString) {
			$arFilter[] = [
				'LOGIC' => 'OR',
				'%=DOCTOR.NAME' => '%'.$searchString.'%',
				'%=DOCTOR.SPECIALITY.ELEMENT.NAME' => '%'.$searchString.'%',
				'%=DOCTOR.SERVICE_SCHEDULE.ELEMENT.NAME' => '%'.$searchString.'%',
				'%=ADDRESS.NAME' => '%'.$searchString.'%'
			];
		}

		if ($specId) {
			$arFilter['DOCTOR.SPECIALITY.ELEMENT.ID'] = $specId;
			$arFilter['DOCTOR.SERVICE_SCHEDULE.ELEMENT.SPECIALITY.VALUE'] = $specId;
		}

		if ($servId) {
			$arFilter['DOCTOR.SERVICE_SCHEDULE.ELEMENT.ID'] = $servId;
		} else {
			$arFilter['!DOCTOR.SERVICE_SCHEDULE.ELEMENT.ID'] = null;
		}

		if ($depId) {
			$arFilter['ADDRESS.ID'] = $depId;
		}

		if ($docId) {
			$arFilter['DOCTOR.ID'] = $docId;
		}

		if ($date && Date::isCorrect($date)) {
			$arFilter['>=START_PERIOD'] = new DateTime($date.' 00:00:00');
			$arFilter['<=END_PERIOD'] = new DateTime($date.' 23:59:59');
		} else {
			$arFilter['>START_PERIOD'] = new DateTime();
			$arFilter['<=END_PERIOD'] = (new DateTime())->add('2 months');
		}

		$arFilter['DOCTOR.ACTIVE'] = 'Y';
		$arFilter['DOCTOR.SPECIALITY.ELEMENT.ACTIVE'] = 'Y';
		$arFilter['DOCTOR.SERVICE_SCHEDULE.ELEMENT.ACTIVE'] = 'Y';
		$arFilter['ADDRESS.ACTIVE'] = 'Y';
		$arFilter['>DURATION'] = 0;




		if (strtolower($page) != 'all') {
			$nav = new PageNavigation('doctors');
			$nav->setPageSize(12)->setCurrentPage($page ?: 1);

			$uniqueDoctorIds = ScheduleTable::getList([
				'select' => [new ExpressionField('UNIQUE_DOCTOR_ID', 'DISTINCT DOCTOR_ID')],
				'filter' => $arFilter,
				'order' => ['DOCTOR.NAME', 'ADDRESS.NAME', 'START_PERIOD'],
			])->fetchAll();

			$nav->setRecordCount(count($uniqueDoctorIds));

			$arSchedule['NEXT_PAGE'] = null;
			if ($nav->getCurrentPage() < $nav->getPageCount()) {
				$arSchedule['NEXT_PAGE'] = ($nav->getCurrentPage() + 1);
			}

			$arFilter['DOCTOR_ID'] = array_column(array_slice($uniqueDoctorIds, $nav->getOffset(), $nav->getLimit()), 'UNIQUE_DOCTOR_ID');
		}




		$schedule = ScheduleTable::getList([
			'select' => ['*', 'ADDRESS.ID', 'ADDRESS.NAME'],
			'filter' => $arFilter,
			'order' => ['DOCTOR.NAME', 'ADDRESS.NAME', 'START_PERIOD'],
		]);
		foreach ($schedule->fetchCollection() as $period) {
			if (!$arSchedule['DOCTORS'][$period->getDoctorId()]) {
				$arSchedule['DOCTORS'][$period->getDoctorId()] = [];
			}

			if (!$arSchedule['DOCTORS'][$period->getDoctorId()]['BRANCHES'][$period->getAddressId()]) {
				$arSchedule['DOCTORS'][$period->getDoctorId()]['BRANCHES'][$period->getAddressId()] = [
					'ID' => $period->getAddress()->getId(),
					'NAME' => $period->getAddress()->getName(),
				];
			}

			if (!$arSchedule['DOCTORS'][$period->getDoctorId()]['BRANCHES'][$period->getAddressId()]['DAYS'][$period->getStartPeriod()->format('d.m.Y')]) {
				$arSchedule['DOCTORS'][$period->getDoctorId()]['BRANCHES'][$period->getAddressId()]['DAYS'][$period->getStartPeriod()->format('d.m.Y')]['DAY'] = [
					'DATE_OBJECT' => new Date($period->getStartPeriod()->format('d.m.Y')),
					'DATE_FORMATTED' => FormatDate('D, d M', (new Date($period->getStartPeriod()->format('d.m.Y')))->getTimestamp()),
				];
			}

			$arSchedule['DOCTORS'][$period->getDoctorId()]['BRANCHES'][$period->getAddressId()]['DAYS'][$period->getStartPeriod()->format('d.m.Y')]['PERIODS'][] = [
				'START_PERIOD' => $period->getStartPeriod(),
				'END_PERIOD' => $period->getEndPeriod(),
				'START_PERIOD_TIMESTAMP' => $period->getStartPeriod()->getTimestamp(),
				'END_PERIOD_TIMESTAMP' => $period->getEndPeriod()->getTimestamp(),
				'DURATION' => $period->getDuration(),
			];

			if (!in_array($period->getDoctorId(), $arDoctorIds)) {
				$arDoctorIds[] = $period->getDoctorId();
			}

			if (!in_array($period->getAddressId(), $arBranchIds)) {
				$arBranchIds[] = $period->getAddressId();
			}
		}




		$doctors = ElementVddoctorsTable::getList([
			'select' => ['ID', 'NAME', 'DETAIL_PICTURE', 'MAIN_SERVICE.ELEMENT.ID', 'ONLINE_SERVICE.ELEMENT.ID', 'HOME_SERVICE.ELEMENT.ID', 'HOME_SERVICE.ELEMENT.NAME', 'HOME_SERVICE.ELEMENT.PRICE', 'HOME_SERVICE.ELEMENT.DURATION', 'SPECIALITY.ELEMENT.ID', 'SPECIALITY.ELEMENT.NAME', 'SERVICE_SCHEDULE.ELEMENT.ID', 'SERVICE_SCHEDULE.ELEMENT.NAME', 'SERVICE_SCHEDULE.ELEMENT.PRICE', 'SERVICE_SCHEDULE.ELEMENT.DURATION', 'SERVICE_SCHEDULE.ELEMENT.SPECIALITY.ELEMENT.ID', 'SERVICE_SCHEDULE.ELEMENT.SPECIALITY.ELEMENT.NAME'],
			'filter' => ['ID' => $arDoctorIds],
		]);
		foreach ($doctors->fetchCollection() as $doctor) {
			$arSchedule['DOCTORS'][$doctor->getId()] = array_merge([
				'ID' => $doctor->getId(),
				'NAME' => $doctor->getName(),
				'PHOTO' => ($doctor->getDetailPicture() ? \CFile::ResizeImageGet($doctor->getDetailPicture(), ['width' => 300, 'height' => 300], BX_RESIZE_IMAGE_PROPORTIONAL, true) : null),
				'SPECIALTIES' => [],
				'MAIN_SERVICE' => null,
				'ONLINE_SERVICE' => null,
				'HOME_SERVICE' => $doctor->getHomeService() ? [
						'ID' => $doctor->getHomeService()->getElement()->getId(),
						'NAME' => $doctor->getHomeService()->getElement()->getName(),
						'PRICE' => Helper::priceFormat($doctor->getHomeService()->getElement()->getPrice()->getValue()),
						'DURATION' => $doctor->getHomeService()->getElement()->getDuration()?->getValue()
					] : null,
				'SERVICES' => []
			], $arSchedule['DOCTORS'][$doctor->getId()]);
			foreach ($doctor->getSpeciality()->getAll() as $s) {
				$obSpec = $s->getElement();
				if (!$arSchedule['DOCTORS'][$doctor->getId()]['SPECIALTIES'][$obSpec->getId()]) {
					$arSchedule['DOCTORS'][$doctor->getId()]['SPECIALTIES'][$obSpec->getId()] = [
						'ID' => $obSpec->getId(),
						'NAME' => $obSpec->getName(),
					];
				}
			}

			foreach ($doctor->getServiceSchedule()->getAll() as $s) {
				$obServ = $s->getElement();
				$arServ = [
					'ID' => $obServ->getId(),
					'NAME' => $obServ->getName(),
					'PRICE' => Helper::priceFormat($obServ->getPrice()->getValue()),
					'DURATION' => $obServ->getDuration()?->getValue(),
				];
				
				if ($doctor->getMainService()?->getElement()->getId() == $obServ->getId()) {
					$arSchedule['DOCTORS'][$doctor->getId()]['MAIN_SERVICE'] = $arServ;
				}
				
				if ($doctor->getOnlineService()?->getElement()->getId() == $obServ->getId()) {
					$arSchedule['DOCTORS'][$doctor->getId()]['ONLINE_SERVICE'] = $arServ;
				} else {
					if ($obServ->getSpeciality()->getAll()) {
						foreach ($obServ->getSpeciality()->getAll() as $spec) {
							$obSpec = $spec->getElement();
							if (!isset($arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'][$obSpec->getId()])) {
								$arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'][$obSpec->getId()] = [
									'ID' => $obSpec->getId(),
									'NAME' => $obSpec->getName()
								];
							}
							$arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'][$obSpec->getId()]['ITEMS'][$arServ['ID']] = $arServ;
						}
					} else {
						if (!isset($arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'][0])) {
							$arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'][0] = [
								'ID' => 0,
								'NAME' => Loc::getMessage('VD_OTHER_SERVICES')
							];
						}
						$arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'][0]['ITEMS'][$arServ['ID']] = $arServ;
					}
				}

				if (!in_array($arServ['ID'], $arServiceIds)) {
					$arServiceIds[] = $arServ['ID'];
				}
			}
			foreach ($arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'] as $specialtyId => $arSpecialty) {
				$arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'][$specialtyId]['ITEMS'] = array_values($arSpecialty['ITEMS']);
			}
			if (isset($arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'][0])) {
				$other = $arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'][0];
				unset($arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'][0]);
				$arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'][0] = $other;
			}
			
			if (!$arSchedule['DOCTORS'][$doctor->getId()]['MAIN_SERVICE'] && $arSchedule['DOCTORS'][$doctor->getId()]['SERVICES']) {
				$fServSectId = array_key_first($arSchedule['DOCTORS'][$doctor->getId()]['SERVICES']);
				$arSchedule['DOCTORS'][$doctor->getId()]['MAIN_SERVICE'] =& $arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'][$fServSectId]['ITEMS'][array_key_first($arSchedule['DOCTORS'][$doctor->getId()]['SERVICES'][$fServSectId]['ITEMS'])];
			}
		}




		$arTicketFilter['=DOCTOR_ID'] = $arDoctorIds;
		$arTicketFilter['=ADDRESS_ID'] = $arBranchIds;

		$arTicketFilter['!STATUS_ID'] = Ticket::getStatusIdByCode('canceled');

		$arTicketFilter['>START_VISIT'] = new DateTime();
		if ($date && Date::isCorrect($date)) {
			$arTicketFilter['>=START_VISIT'] = new DateTime($date.'00:00:00');
			$arTicketFilter['<=END_VISIT'] = new DateTime($date.'23:59:59');
		}
		$tickets = TicketTable::getList([
			'filter' => $arTicketFilter,
		]);
		while ($arTicket = $tickets->fetch()) {
			if ($arSchedule['DOCTORS'][$arTicket['DOCTOR_ID']]['BRANCHES'][$arTicket['ADDRESS_ID']]['DAYS'][$arTicket['START_VISIT']->format('d.m.Y')]) {
				$arSchedule['DOCTORS'][$arTicket['DOCTOR_ID']]['BRANCHES'][$arTicket['ADDRESS_ID']]['DAYS'][$arTicket['START_VISIT']->format('d.m.Y')]['TICKETS'][] = $arTicket;
			}
		}

		foreach ($arSchedule['DOCTORS'] as $doctorId => $arDoctor) {
			foreach ($arDoctor['SERVICES'] as $sectionId => $arSection) {
				$arSchedule['DOCTORS'][$doctorId]['SERVICES'][$sectionId]['ITEMS'] = array_values($arSection['ITEMS']);
			}
		}

		return $arSchedule;
	}

	public function blockAction($docId, $dateStart, $dateEnd, $patId = null, $depId = null, $servId = null) {
		try {
			if (
				$patId
				&& $q = TicketTable::getList([
					'filter' => ['PATIENT_ID' => $patId, 'DOCTOR_ID' => $docId, '>=START_VISIT' => date('d.m.Y 00:00:00' , strtotime($dateStart)), '<=START_VISIT' => date('d.m.Y 23:59:59' , strtotime($dateEnd))],
					'select' => ['ID'],
					'limit' => 1,
				])->fetch()
			) {
				throw new \Exception(Loc::getMessage('VD_ERROR_ALREADY_APPOINTED_TO_THIS_DOCTOR'));
			}

			if (
				$patId
				&& $q = TicketTable::getList([
					'filter' => ['PATIENT_ID' => $patId, '!DOCTOR_ID' => $docId, '<START_VISIT' => $dateEnd, '>END_VISIT' => $dateStart],
					'select' => ['ID'],
					'limit' => 1,
				])->fetch()
			) {
				throw new \Exception(Loc::getMessage('VD_ERROR_ALREADY_APPOINTED_ON_THIS_TIME'));
			}

			if (!DateTime::isCorrect($dateStart) || strtotime($dateStart) < time() || !DateTime::isCorrect($dateEnd) || strtotime($dateEnd) < time()) {
				throw new \Exception(Loc::getMessage('VD_ERROR_DATE_INCORRECT'));
			}

			$ticketReservedStatusId = TicketStatusTable::getList([
				'filter' => ['CODE' => 'reserved'],
				'select' => ['ID'],
				'limit' => 1,
			])->fetch()['ID'];

			$obTicket = TicketTable::createObject();
			$obTicket
				->setDoctorId($docId)
				->setStartVisit(new DateTime($dateStart))
				->setEndVisit(new DateTime($dateEnd))
				->setStatusId($ticketReservedStatusId);

			if ($depId) {
				$obTicket->setAddressId($depId);
			}

			if ($servId) {
				$obService = ElementVdservicesTable::wakeUpObject($servId);
				$obTicket->addToServices($obService);
			}

			if ($patId) {
				$obTicket->setPatientId($patId);
			}

			$result = $obTicket->save();
			if (!$result->isSuccess()) {
				throw new \Exception(Loc::getMessage('VD_ERROR_TICKET_NOT_SAVED'));
			}
		} catch(\Exception $e) {
			$this->addError(new Error($e->getMessage()));
			return null;
		}

		return $result->getId();
	}

	public function unblockAction($ticketId) {
		try {
			if (
				!($obTicket = TicketTable::getList([
					'filter' => ['ID' => $ticketId],
					'limit' => 1,
				])->fetchObject())
			) {
				throw new \Exception(Loc::getMessage('VD_ERROR_TICKET_NOT_FOUND'));
			}

			$obTicket->removeAllServices();
			$obTicket->delete();
		} catch(\Exception $e) {
			$this->addError(new Error($e->getMessage()));
			return null;
		}

		return true;
	}

	public function confirmAction($ticketId, $patId = null, $ticketPatientLastName = null, $ticketPatientName = null, $ticketPatientSecondName = null, $ticketPatientPhone = null) {
		$arRecordResult = [
			'SUCCESS' => false
		];

		try {
			if (
				!($obTicket = TicketTable::getList([
					'select' => ['*', 'DOCTOR.NAME', 'DOCTOR.DETAIL_PICTURE', 'DOCTOR.SPECIALITY.ELEMENT', 'ADDRESS.NAME', 'SERVICES'],
					'filter' => ['ID' => $ticketId],
					'limit' => 1,
				])->fetchObject())
			) {
				throw new \Exception(Loc::getMessage('VD_ERROR_TICKET_NOT_FOUND'));
			}

			if (
				$patId
				&& $q = TicketTable::getList([
					'filter' => ['PATIENT_ID' => $patId, '!ID' => $ticketId, 'DOCTOR_ID' => $obTicket->getDoctorId(), '>=START_VISIT' => date('d.m.Y 00:00:00' , $obTicket->getStartVisit()->getTimestamp()), '<=START_VISIT' => date('d.m.Y 23:59:59' , $obTicket->getEndVisit()->getTimestamp())],
					'select' => ['ID'],
					'limit' => 1,
				])->fetch()
			) {
				throw new \Exception(Loc::getMessage('VD_ERROR_ALREADY_APPOINTED_TO_THIS_DOCTOR'));
			}

			if (
				$patId
				&& $q = TicketTable::getList([
					'filter' => ['PATIENT_ID' => $patId, '!ID' => $ticketId, '!DOCTOR_ID' => $obTicket->getDoctorId(), '<START_VISIT' => $obTicket->getEndVisit(), '>END_VISIT' => $obTicket->getStartVisit()],
					'select' => ['ID'],
					'limit' => 1,
				])->fetch()
			) {
				throw new \Exception(Loc::getMessage('VD_ERROR_ALREADY_APPOINTED_ON_THIS_TIME'));
			}

			if ($patId) {
				$obTicket->setPatientId($patId);
			}

			if (!$patId = $obTicket->getPatientId()) {
				if (
					!($obTicketPatient = TicketPatientTable::getList([
						'filter' => ['LAST_NAME' => $ticketPatientLastName, 'NAME' => $ticketPatientName, 'SECOND_NAME' => $ticketPatientSecondName, 'PHONE' => $ticketPatientPhone]
					])->fetchObject())
				) {
					$obTicketPatient = TicketPatientTable::createObject();
					$obTicketPatient
						->setLastName($ticketPatientLastName)
						->setName($ticketPatientName)
						->setSecondName($ticketPatientSecondName)
						->setPhone($ticketPatientPhone)
						->save();
				}
				$obTicket->setTicketPatientId($obTicketPatient->getId());
			}

			$ticketConfirmedStatusId = TicketStatusTable::getList([
				'filter' => ['CODE' => 'created'],
				'select' => ['ID'],
				'limit' => 1,
			])->fetch()['ID'];

			$obTicket
				->setStatusId($ticketConfirmedStatusId)
				->save();

			$arRecordResult['SUCCESS'] = true;
		} catch(\Exception $e) {
			$this->addError(new Error($e->getMessage()));
			return null;
		}

		return $arRecordResult;
	}
}
