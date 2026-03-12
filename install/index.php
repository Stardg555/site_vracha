<?php

use Bitrix\Main\{
	SiteTable,
	Application,
	Config\Option,
	IO\File,
	IO\Directory,
	Localization\Loc,
	ModuleManager
};

Loc::loadMessages(__FILE__);

CModule::IncludeModule('iblock');

class vit_doctor extends CModule
{
	var $MODULE_ID = 'vit.doctor';

	public array $arIBlockTypes = [
		'vd_catalogs',
		'vd_content',
		'vd_employees',
		'vd_forms',
		'vd_contacts',
		'vd_reviews'
	];

	public array $arEvents = [
		'VD_FORM_CALLBACK',
		'VD_FORM_REVIEW',
		'VD_FORM_DOCTOR_HOME'
	];

	public function __construct()
	{
		$arModuleVersion = [];
		include(__DIR__.'/version.php');

		$this->MODULE_VERSION = $arModuleVersion['VERSION'];
		$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		$this->MODULE_NAME = Loc::getMessage('VIT_DOCTOR_MODULE_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage('VIT_DOCTOR_MODULE_DESCRIPTION');
		$this->PARTNER_NAME = Loc::getMessage('VIT_DOCTOR_PARTNER_NAME');
		$this->PARTNER_URI = Loc::getMessage('VIT_DOCTOR_PARTNER_URI');
	}

    public function getPath(bool $notDocumentRoot = false) : string
    {
        if ($notDocumentRoot) {
			return str_ireplace(Application::getDocumentRoot(), '', dirname(__DIR__));
		} else {
			return dirname(__DIR__);
		}
    }

    public function checkVersion(string $version) : bool
    {
        return CheckVersion(ModuleManager::getVersion('main'), $version);
    }

	public function InstallDB()
	{
		include(__DIR__.'/db.php');
		return true;
	}

	public function UnInstallDB()
	{
		Option::delete($this->MODULE_ID);
		include(__DIR__.'/db-uninstall.php');
	}

	public function InstallFiles()
	{
		CopyDirFiles($this->GetPath().'/install/wizards', $_SERVER['DOCUMENT_ROOT'].'/bitrix/wizards', true, true);
		return true;
	}

	public function UnInstallFiles()
	{
		Directory::deleteDirectory($_SERVER['DOCUMENT_ROOT'].'/bitrix/wizards/vit/');
		Directory::deleteDirectory($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/vc-doctor/');
		
		$siteDirectory = $this->getSiteDirectory();
		if (!empty($siteDirectory)) {
			$path = $this->GetPath().'/install/wizards/vit/doctor/site/public/'.LANGUAGE_ID.'/';
			$handle = @opendir($path);
			if ($handle) {
				while ($file = readdir($handle)) {
					if (in_array($file, ['.', '..'])) {
						continue;
					}

					Directory::deleteDirectory($_SERVER['DOCUMENT_ROOT'].$siteDirectory.$file);
				}
			}

			File::putFileContents($_SERVER['DOCUMENT_ROOT'].$siteDirectory.'index.php', '');
		}

		return true;
	}

	public function getSiteDirectory() : string
	{	
		$siteDirectory = '';
		$siteId = Option::get($this->MODULE_ID, 'site');

		if (!empty($siteId)) {
			$arSite = SiteTable::getList([
				'select' => ['DIR'],
				'filter' => ['LID' => $siteId]
			])->fetch();

			if (!empty($arSite)) {
				$siteDirectory = $arSite['DIR'];
			}
		}
		
		return $siteDirectory;
	}

	public function UnInstallIBlockTypes()
	{
		foreach ($this->arIBlockTypes as $iBlockType) {
			\CIBlockType::Delete($iBlockType);
		}
	}

	public function UnInstallEvents()
	{
		$obEventType = new \CEventType;
		$obEventMessage = new \CEventMessage;
		$arEventMessageIds = $this->getEventMessageIdsByCodes($this->arEvents);
		
		foreach ($this->arEvents as $event) {
			$obEventType->Delete($event);
			$obEventMessage->Delete($arEventMessageIds[$event]);
		}
	}

	public function getEventMessageIdsByCodes(array $eventMessageCodes) : array
	{	
		$arEventMessageIds = [];

		$eventMessages = \CEventMessage::GetList($by = '', $order = '', ['TYPE_ID' => $eventMessageCodes]);
		while ($arEventMessage = $eventMessages->Fetch()) {
			$arEventMessageIds[$arEventMessage['EVENT_TYPE']] = $arEventMessage['ID'];
		}

		return $arEventMessageIds;
	}

	public function DoInstall()
	{
		global $APPLICATION;

		if ($this->checkVersion('20.00.00')) {
			$this->InstallFiles();
			$this->InstallDB();

			ModuleManager::registerModule($this->MODULE_ID);
		} else {
			$APPLICATION->ThrowException(Loc::getMessage('VIT_DOCTOR_INSTALL_ERROR_VERSION'));
		}

		$APPLICATION->IncludeAdminFile(Loc::getMessage('VIT_DOCTOR_INSTALL_TITLE'), $this->getPath().'/install/step.php');
	}

	public function DoUninstall()
	{
		global $APPLICATION;

		$this->UnInstallFiles();
		$this->UnInstallDB();
		$this->UnInstallIBlockTypes();
		$this->UnInstallEvents();

		ModuleManager::unRegisterModule($this->MODULE_ID);

		$APPLICATION->IncludeAdminFile(Loc::getMessage('VIT_DOCTOR_UNINSTALL_TITLE'), $this->getPath().'/install/unstep.php');
	}
}
