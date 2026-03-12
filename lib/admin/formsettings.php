<?php

namespace Vit\Doctor\Admin;

use Vit\Doctor\Helper;

class FormSettings
{
    public static function get(string $formId) : array {
        return \CAdminFormSettings::getTabsArray($formId);
    }

    public static function getWithPropertyCodes(string $formId, bool $excludeXmlId = true) : array {
        $arTabs = self::get($formId);
        foreach ($arTabs as $tabId => $arTab) {
            $arFields = [];
            foreach ($arTab['FIELDS'] as $fieldId => $field) {
                if ($excludeXmlId && $fieldId == 'XML_ID') {
                    continue;
                }

                if (strpos($fieldId, 'PROPERTY_') === false || strpos($fieldId, 'IPROPERTY_') !== false) {
                    $arFields[$fieldId] = $field;
                } else {
                    $arFields['PROPERTY_'.Helper::getPropertyCodeById(str_replace('PROPERTY_', '', $fieldId))] = $field;
                }
            }

            if (!empty($arFields)) {
                $arTabs[$tabId]['FIELDS'] = $arFields;
            }
        }
        return $arTabs;
    }

    public static function set(string $formId, array $arTabs, $common = false, $userId = false) : void {
        \CAdminFormSettings::setTabsArray($formId, $arTabs, $common, $userId);
    }

    public static function setWithPropertyCodes(int $iblockId, string $formId, array $arTabs, $common = true, $userId = false) : void {
        foreach ($arTabs as $tabId => $arTab) {
            $arFields = [];
            foreach ($arTab['FIELDS'] as $fieldId => $field) {
                if (strpos($fieldId, 'PROPERTY_') === false || strpos($fieldId, 'IPROPERTY_') !== false) {
                    $arFields[$fieldId] = $field;
                } else {
                    $arFields['PROPERTY_'.Helper::getPropertyIdByCode($iblockId, str_replace('PROPERTY_', '', $fieldId))] = $field;
                }
            }

            if (!empty($arFields)) {
                $arTabs[$tabId]['FIELDS'] = $arFields;
            }
        }
        self::set($formId, $arTabs, $common, $userId);
    }
}
