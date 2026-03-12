<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

use Vit\Doctor\{
	Helper,
	Admin\FormSettings
};
use Bitrix\Main\Localization\Loc;

if(!CModule::IncludeModule("iblock"))
	return;

if(!CModule::IncludeModule("vit.doctor"))
	return;

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/vd-doctors.xml";
$iblockCode = "vd-doctors";
$iblockType = "vd_employees";

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
$iblockID = false;
if ($arIBlock = $rsIBlock->Fetch())
{
	$iblockID = $arIBlock["ID"];
}

if($iblockID == false)
{
	$iblockID = WizardServices::ImportIBlockFromXML(
		$iblockXMLFile,
		$iblockCode,
		$iblockType,
		WIZARD_SITE_ID,
		array(
			"1" => "X",
			"2" => "R"
		)
	);

	if ($iblockID < 1)
		return;

	$iblock = new CIBlock;
	$arFields = Array(
		"ACTIVE" => "Y",
		"FIELDS" => unserialize(Loc::getMessage('IBLOCK_FIELDS')),
		"CODE" => $iblockCode,
		"API_CODE" => "vddoctors",
		"XML_ID" => $iblockCode,
		"NAME" => $iblock->GetArrayByID($iblockID, "NAME")
	);

	$iblock->Update($iblockID, $arFields);

	$property = new CIBlockProperty;
	$property->Update(Helper::getPropertyIdByCode($iblockID, 'SPECIALITY'), array('LINK_IBLOCK_ID' => Helper::getIblockIdByCode('vd-specialties')));
	$property->Update(Helper::getPropertyIdByCode($iblockID, 'ADDRESS'), array('LINK_IBLOCK_ID' => Helper::getIblockIdByCode('vd-addresses')));
	$property->Update(Helper::getPropertyIdByCode($iblockID, 'MAIN_SERVICE'), array('LINK_IBLOCK_ID' => Helper::getIblockIdByCode('vd-services')));
	$property->Update(Helper::getPropertyIdByCode($iblockID, 'SERVICE_SCHEDULE'), array('LINK_IBLOCK_ID' => Helper::getIblockIdByCode('vd-services')));
	$property->Update(Helper::getPropertyIdByCode($iblockID, 'HOME_SERVICE'), array('LINK_IBLOCK_ID' => Helper::getIblockIdByCode('vd-services')));
	$property->Update(Helper::getPropertyIdByCode($iblockID, 'ONLINE_SERVICE'), array('LINK_IBLOCK_ID' => Helper::getIblockIdByCode('vd-services')));

	FormSettings::setWithPropertyCodes($iblockID, 'form_element_'.$iblockID, unserialize(Loc::getMessage('FORM_ELEMENT_TABS')));
}
else
{
	$arSites = array();
	$db_res = CIBlock::GetSite($iblockID);
	while ($res = $db_res->Fetch())
		$arSites[] = $res["LID"];
	if (!in_array(WIZARD_SITE_ID, $arSites))
	{
		$arSites[] = WIZARD_SITE_ID;
		$iblock = new CIBlock;
		$iblock->Update($iblockID, array("LID" => $arSites));
	}
}
?>