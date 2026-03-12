<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use Bitrix\Main\{
	Loader,
	Config\Option,
	Localization\Loc,
	Page\Asset
};

Loader::includeModule('vit.doctor');
CUtil::InitJSCore();
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php $APPLICATION->ShowTitle(); ?></title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="msapplication-TileColor" content="#603cba">
		<meta name="theme-color" content="#ffffff">

        <link rel="shortcut icon" href="<?= SITE_DIR.'favicon.ico'; ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= SITE_DIR.'apple-touch-icon.png'; ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= SITE_DIR.'favicon-32x32.png'; ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= SITE_DIR.'favicon-16x16.png'; ?>">
        <link rel="manifest" href="<?= SITE_DIR.'site.webmanifest'; ?>">
        <link rel="mask-icon" href="<?= SITE_DIR.'safari-pinned-tab.svg'; ?>" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

		<style>
			:root {
				--vc-primary-light: #3dadfd;
                --vc-primary: <?= $GLOBALS['VD_SETTINGS']['main_color']; ?>;
				--vc-black: #41404D;
				--vc-white: #ffffff;
				--vc-transparent: rgba(0, 0, 0, 0);
			}
		</style>

		<?php
		Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/assets/css/app.css');
		Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/assets/js/app.js');
		echo $GLOBALS['VD_SETTINGS']['meta'];
		$APPLICATION->ShowHead();
		?>
	</head>
	<body class="vc-body">
		<?php $APPLICATION->ShowPanel(); ?>
		<header class="vc-header">
            <div class="vc-center">
                <div class="vc-header__content">
                    <a href="<?= SITE_DIR; ?>" class="vc-header__logo">
                        <?php $APPLICATION->IncludeFile(SITE_DIR.'includes/header/logo.inc.php', [], [
                            'SHOW_BORDER' => 'true',
                            'MODE' => 'php'
                        ]);	?>
                    </a>
                    <div class="vc-header__menu">
                        <?php $APPLICATION->IncludeComponent('bitrix:menu', 'vd-main', [
                            'ALLOW_MULTI_SELECT' => 'N',
                            'CHILD_MENU_TYPE' => '',
                            'DELAY' => 'N',
                            'MAX_LEVEL' => '1',
                            'MENU_CACHE_GET_VARS' => [],
                            'MENU_CACHE_TIME' => '3600',
                            'MENU_CACHE_TYPE' => 'A',
                            'MENU_CACHE_USE_GROUPS' => 'N',
                            'ROOT_MENU_TYPE' => 'main',
                            'USE_EXT' => 'N'
                        ]); ?>
                    </div>
                    <div class="vc-header__record">
                        <a href="#record" class="vc-btn">
                            <?= Loc::getMessage('VC_MAKE_APPOINTMENT'); ?>
                        </a>
                    </div>
                    <div class="vc-header__burger">
                        <div class="vc-header__burger-line"></div>
                        <div class="vc-header__burger-line"></div>
                        <div class="vc-header__burger-line"></div>
                    </div>
                </div>
            </div>
		</header>
		<main class="vc-main">
