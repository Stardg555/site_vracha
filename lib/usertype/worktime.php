<?php
namespace Vit\Doctor\UserType;


use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

/**
 * График работы по дням недели 
 *
  */
class WorkTime extends \CUserTypeString
{
    
    static private $weekdaysMetaNames = [
        'MONDAY',
        'TUESDAY',
        'WEDNESDAY',
        'THURSDAY',
        'FRIDAY',
        'SATURDAY',
        'SUNDAY',
    ];

    static function GetUserTypeDescription(): array
    {
        return [
            'PROPERTY_TYPE' => 'S',
            'USER_TYPE' => 'worktime',
            'DESCRIPTION' => Loc::getMessage('VD_UT_WORKTIME_FIELD_TITLE'),
            'GetPropertyFieldHtml' => [__CLASS__,'getEditFormHTMLCustom'],
            'GetPublicViewHTML' =>[__CLASS__, "getPublicViewHTML"],
            'ConvertToDB' => [__CLASS__, 'convertToDB'],
            'ConvertFromDB' => [__CLASS__, 'convertFromDB'],
            'GetAdminListViewHTML' => [__CLASS__,"getAdminListViewHTMLCustom"],

        ];
    }

    static function getEditFormHTMLCustom($arProperty, $value, $strHTMLControlName)
    {

        if (empty($value["VALUE"])) {
            $value = [];
            foreach (self::$weekdaysMetaNames as $weekDay) {
                $value["VALUE"][$weekDay] = '';
            }
        }

        $arValue = $value["VALUE"];
        
        $inputTemplate = '<table>';
        $inputTemplate .= '<tr><td>'.Loc::getMessage('VD_UT_WORKTIME_MONDAY').'</td>'
                . '<td><input name="'.$strHTMLControlName["VALUE"].'[MONDAY]" type="checkbox" value="Y" '.($arValue['MONDAY'] == 'Y' ? " checked ": "").' /><td>'
                . '<td><input type="text" name="'.$strHTMLControlName["VALUE"].'[MONDAY_WORKTIME]" value="'.$arValue['MONDAY_WORKTIME'].'" placeholder="'.Loc::getMessage('VD_UT_WORKTIME_ADMIN_PLACEHOLDER').'"  /></td></tr>';
        $inputTemplate .= '<tr><td>'.Loc::getMessage('VD_UT_WORKTIME_TUESDAY').'</td>'
                . '<td><input name="'.$strHTMLControlName["VALUE"].'[TUESDAY]" type="checkbox" value="Y" '.($arValue['TUESDAY'] == 'Y' ? " checked ": "").' /><td>'
                . '<td><input type="text" name="'.$strHTMLControlName["VALUE"].'[TUESDAY_WORKTIME]" value="'.$arValue['TUESDAY_WORKTIME'].'" placeholder="'.Loc::getMessage('VD_UT_WORKTIME_ADMIN_PLACEHOLDER').'"  /></td></tr>';
        $inputTemplate .= '<tr><td>'.Loc::getMessage('VD_UT_WORKTIME_WEDNESDAY').'</td>'
                . '<td><input name="'.$strHTMLControlName["VALUE"].'[WEDNESDAY]" type="checkbox" value="Y" '.($arValue['WEDNESDAY'] == 'Y' ? " checked ": "").' /><td>'
                . '<td><input type="text" name="'.$strHTMLControlName["VALUE"].'[WEDNESDAY_WORKTIME]" value="'.$arValue['WEDNESDAY_WORKTIME'].'" placeholder="'.Loc::getMessage('VD_UT_WORKTIME_ADMIN_PLACEHOLDER').'"  /></td></tr>';
        $inputTemplate .= '<tr><td>'.Loc::getMessage('VD_UT_WORKTIME_THURSDAY').'</td>'
                . '<td><input name="'.$strHTMLControlName["VALUE"].'[THURSDAY]" type="checkbox" value="Y" '.($arValue['THURSDAY'] == 'Y' ? " checked ": "").' /><td>'
                . '<td><input type="text" name="'.$strHTMLControlName["VALUE"].'[THURSDAY_WORKTIME]" value="'.$arValue['THURSDAY_WORKTIME'].'" placeholder="'.Loc::getMessage('VD_UT_WORKTIME_ADMIN_PLACEHOLDER').'"  /></td></tr>';
        $inputTemplate .= '<tr><td>'.Loc::getMessage('VD_UT_WORKTIME_FRIDAY').'</td>'
                . '<td><input name="'.$strHTMLControlName["VALUE"].'[FRIDAY]" type="checkbox" value="Y" '.($arValue['FRIDAY'] == 'Y' ? " checked ": "").' /><td>'
                . '<td><input type="text" name="'.$strHTMLControlName["VALUE"].'[FRIDAY_WORKTIME]" value="'.$arValue['FRIDAY_WORKTIME'].'" placeholder="'.Loc::getMessage('VD_UT_WORKTIME_ADMIN_PLACEHOLDER').'"  /></td></tr>';
        $inputTemplate .= '<tr><td>'.Loc::getMessage('VD_UT_WORKTIME_SATURDAY').'</td>'
                . '<td><input name="'.$strHTMLControlName["VALUE"].'[SATURDAY]" type="checkbox" value="Y" '.($arValue['SATURDAY'] == 'Y' ? " checked ": "").' /><td>'
                . '<td><input type="text" name="'.$strHTMLControlName["VALUE"].'[SATURDAY_WORKTIME]" value="'.$arValue['SATURDAY_WORKTIME'].'" placeholder="'.Loc::getMessage('VD_UT_WORKTIME_ADMIN_PLACEHOLDER').'"  /></td></tr>';
        $inputTemplate .= '<tr><td>'.Loc::getMessage('VD_UT_WORKTIME_SUNDAY').'</td>'
                . '<td><input name="'.$strHTMLControlName["VALUE"].'[SUNDAY]" type="checkbox" value="Y" '.($arValue['SUNDAY'] == 'Y' ? " checked ": "").' /><td>'
                . '<td><input type="text" name="'.$strHTMLControlName["VALUE"].'[SUNDAY_WORKTIME]" value="'.$arValue['SUNDAY_WORKTIME'].'" placeholder="'.Loc::getMessage('VD_UT_WORKTIME_ADMIN_PLACEHOLDER').'"  /></td></tr>';
        $inputTemplate .= '</table>';
        return $inputTemplate;
    }
    

    static function getAdminListViewHTMLCustom($arProperty, $value, $strHTMLControlName)
    {
        $arValue = $value["VALUE"];
        return Loc::getMessage('VD_UT_WORKTIME_MONDAY_SHORT').$arValue['MONDAY']."&nbsp;".$arValue['MONDAY_WORKTIME'].";&nbsp;"
                .Loc::getMessage('VD_UT_WORKTIME_TUESDAY_SHORT').$arValue['TUESDAY']."&nbsp;".$arValue['TUESDAY_WORKTIME'].";&nbsp;"
                .Loc::getMessage('VD_UT_WORKTIME_WEDNESDAY_SHORT').$arValue['WEDNESDAY']."&nbsp;".$arValue['WEDNESDAY_WORKTIME'].";&nbsp;"
                .Loc::getMessage('VD_UT_WORKTIME_THURSDAY_SHORT').$arValue['THURSDAY']."&nbsp;".$arValue['THURSDAY_WORKTIME'].";&nbsp;"
                .Loc::getMessage('VD_UT_WORKTIME_FRIDAY_SHORT').$arValue['FRIDAY']."&nbsp;".$arValue['FRIDAY_WORKTIME'].";&nbsp;"
                .Loc::getMessage('VD_UT_WORKTIME_SATURDAY_SHORT').$arValue['SATURDAY']."&nbsp;".$arValue['SATURDAY_WORKTIME'].";&nbsp;"
                .Loc::getMessage('VD_UT_WORKTIME_SUNDAY_SHORT').$arValue['SUNDAY']."&nbsp;".$arValue['SUNDAY_WORKTIME'].";&nbsp;";
    }

    
    /**
     * Функция вызывается перед сохранением значений в БД
     * @param $arProperty
     * @param $arValue
     * @return string - значение для вставки в БД
     */
    static public function convertToDB($arProperty, $arValue)
    {
        $result=[];
        if (!empty($arValue['VALUE'])) {
            
            $result['MONDAY'] = trim(\htmlspecialcharsbx($arValue['VALUE']['MONDAY']));
            $result['MONDAY_WORKTIME'] = trim(\htmlspecialcharsbx($arValue['VALUE']['MONDAY_WORKTIME']));
            $result['TUESDAY'] = trim(\htmlspecialcharsbx($arValue['VALUE']['TUESDAY']));
            $result['TUESDAY_WORKTIME'] = trim(\htmlspecialcharsbx($arValue['VALUE']['TUESDAY_WORKTIME']));
            $result['WEDNESDAY'] = trim(\htmlspecialcharsbx($arValue['VALUE']['WEDNESDAY']));
            $result['WEDNESDAY_WORKTIME'] = trim(\htmlspecialcharsbx($arValue['VALUE']['WEDNESDAY_WORKTIME']));
            $result['THURSDAY'] = trim(\htmlspecialcharsbx($arValue['VALUE']['THURSDAY']));
            $result['THURSDAY_WORKTIME'] = trim(\htmlspecialcharsbx($arValue['VALUE']['THURSDAY_WORKTIME']));
            $result['FRIDAY'] = trim(\htmlspecialcharsbx($arValue['VALUE']['FRIDAY']));
            $result['FRIDAY_WORKTIME'] = trim(\htmlspecialcharsbx($arValue['VALUE']['FRIDAY_WORKTIME']));
            $result['SATURDAY'] = trim(\htmlspecialcharsbx($arValue['VALUE']['SATURDAY']));
            $result['SATURDAY_WORKTIME'] = trim(\htmlspecialcharsbx($arValue['VALUE']['SATURDAY_WORKTIME']));
            $result['SUNDAY'] = trim(\htmlspecialcharsbx($arValue['VALUE']['SUNDAY']));
            $result['SUNDAY_WORKTIME'] = trim(\htmlspecialcharsbx($arValue['VALUE']['SUNDAY_WORKTIME']));
            return ['VALUE' => serialize($result)];
        } else {
            return '';
        }
    }
    
    static function convertFromDB($arProperty, $value)
    {
        if (!empty($value)) {
            $result= unserialize($value['VALUE']);
            return ['VALUE' => $result];
        }
        return '';
    }
}