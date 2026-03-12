<?php

namespace Vit\Doctor;

use Bitrix\{
    Main\Loader,
    Main\UserFieldTable,
    Main\GroupTable,
    Main\Localization\Loc,
    Iblock\IblockTable,
    Iblock\PropertyTable
};

class Helper
{
    public static function getIblockIdByCode($code)
    {
        Loader::includeModule('iblock');
        if (
            $result = IblockTable::getList([
                'filter' => ['CODE' => $code],
                'select' => ['ID'],
                'cache' => [
                    'ttl' => 36000000
                ]
            ])->fetchAll()
        ) {
            return (count($result = array_column($result, 'ID')) == 1 ? array_shift($result) : $result);
        }
        return false;
    }

    public static function getPropertyIdByCode($iblock, $code)
    {
        Loader::includeModule('iblock');
        if (
            $result = PropertyTable::getList([
                'filter' => ['IBLOCK_ID' => $iblock, 'CODE' => $code],
                'select' => ['ID'],
                'cache' => [
                    'ttl' => 36000000
                ]
            ])->fetchAll()
        ) {
            return (count($result = array_column($result, 'ID')) == 1 ? array_shift($result) : $result);
        }
        return false;
    }

    public static function getPropertyCodeById($id)
    {
        Loader::includeModule('iblock');
        if (
            $result = PropertyTable::getList([
                'filter' => ['ID' => $id],
                'select' => ['CODE'],
                'cache' => [
                    'ttl' => 36000000
                ]
            ])->fetchAll()
        ) {
            return (count($result = array_column($result, 'CODE')) == 1 ? array_shift($result) : $result);
        }
        return false;
    }

    public static function getUserGroupIdByCode($code)
    {
        if (
            $result = GroupTable::getList([
                'filter' => ['STRING_ID' => $code],
                'select' => ['ID'],
                'cache' => [
                    'ttl' => 36000000
                ]
            ])->fetchAll()
        ) {
            return (count($result = array_column($result, 'ID')) == 1 ? array_shift($result) : $result);
        }
        return false;
    }

    public static function getUserFieldIdByCode($entity, $code)
    {
        if (
            $result = UserFieldTable::getList([
                'filter' => ['ENTITY_ID' => $entity, 'FIELD_NAME' => $code],
                'select' => ['ID'],
                'cache' => [
                    'ttl' => 36000000
                ]
            ])->fetchAll()
        ) {
            return (count($result = array_column($result, 'ID')) == 1 ? array_shift($result) : $result);
        }
        return false;
    }

    public static function fetch($url, $params = [])
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $params['method']);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $params['headers']);
        if (strtolower($params['method']) == 'post' && $params['body']) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params['body']);
        }

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

	public static function declAfterNum($value, $words, $show = true)
	{
		$num = $value % 100;
		if ($num > 19) {
			$num = $num % 10;
		}

		$out = ($show) ?  $value . ' ' : '';
		switch ($num) {
			case 1:  $out .= $words[0]; break;
			case 2:
			case 3:
			case 4:  $out .= $words[1]; break;
			default: $out .= $words[2]; break;
		}

		return $out;
	}

    public static function secondsToTimeArray(int $seconds) : array
    {
        $arTime = [];
	
        $arTime['days'] = floor($seconds / 86400);
        $seconds = $seconds % 86400;
        
        $arTime['hours'] = floor($seconds / 3600);
        $seconds = $seconds % 3600;
     
        $arTime['minutes'] = floor($seconds / 60);
        $arTime['seconds'] = $seconds % 60;
     
        return $arTime;
    }

    public static function secondsToTimeString(int $seconds) : string
    {
        $arTimeFormatted = [];
        $arTime = self::secondsToTimeArray($seconds);

        if ($arTime['days']) {
            $arTimeFormatted['days'] = self::declAfterNum($arTime['days'], [Loc::getMessage('DAYS_1'), Loc::getMessage('DAYS_2'), Loc::getMessage('DAYS_5')]);
        }

        if ($arTime['hours']) {
            $arTimeFormatted['hours'] = self::declAfterNum($arTime['hours'], [Loc::getMessage('HOURS_1'), Loc::getMessage('HOURS_2'), Loc::getMessage('HOURS_5')]);
        }
        
        if ($arTime['minutes']) {
            $arTimeFormatted['minutes'] = self::declAfterNum($arTime['minutes'], [Loc::getMessage('MINUTES_1'), Loc::getMessage('MINUTES_2'), Loc::getMessage('MINUTES_5')]);
        }
        
        if ($arTime['seconds']) {
            $arTimeFormatted['seconds'] = self::declAfterNum($arTime['seconds'], [Loc::getMessage('SECONDS_1'), Loc::getMessage('SECONDS_2'), Loc::getMessage('SECONDS_5')]);
        }

        return implode(' ', $arTimeFormatted);
    }

    public static function numberFormat($value, $unit = '')
    {
        $value = number_format($value, 2, ',', ' ');
        $value = str_replace(',00', '', $value);

        if (!empty($unit)) {
            $value .= ' ' . $unit;
        }

        return $value;
    }

    public static function priceFormat($value)
    {
        return self::numberFormat($value, '₽');
    }
}
