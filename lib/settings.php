<?php

namespace Vit\Doctor;

use Bitrix\Main\{
    Application,
    Config\Option
};

class Settings
{
    public static array $arSettingsCodes = [
        'main_color',
        'doctor',
        'meta',
        'counters'
    ];
      
    public static function get(string $settingCode, bool $considerDemo = false) : string {
        return ($considerDemo && !empty($_SESSION['VD_SETTINGS'][$settingCode]) ? $_SESSION['VD_SETTINGS'][$settingCode] : Option::get('vit.doctor', $settingCode));
    }

    public static function set(string $settingCode, string $settingValue, bool $considerDemo = false) : void {
        if ($considerDemo) {
            $_SESSION['VD_SETTINGS'][$settingCode] = $settingValue;
        } else {
            Option::set('vit.doctor', $settingCode, $settingValue);
        }
    }

    public static function getAll(bool $considerDemo = false) : array {
        $arSettings = [];
        foreach (self::$arSettingsCodes as $settingCode) {
            $arSettings[$settingCode] = self::get($settingCode, $considerDemo);
        }
        return $arSettings;
    }
}
