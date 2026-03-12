<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use Vit\Doctor\Helper;
use Bitrix\Main\{
	Config\Option,
	Localization\Loc
};
use Bitrix\Main\Data\StaticHTMLCache;
?>

		</main>
		<footer class="vc-footer">
			<div class="vc-center">
                <div class="vc-footer__wrapper">
                    <div class="vc-footer__copy">
                        <?php $APPLICATION->IncludeFile(SITE_DIR.'includes/footer/copyright.inc.php', [], [
                            'SHOW_BORDER' => 'true',
                            'MODE' => 'php'
                        ]);	?>
                    </div>
                    <a href="https://thevit.ru/" target="_blank" class="vc-footer__vit">
                        <?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/footer/vit.svg'); ?>
                    </a>
                </div>
			</div>
            <div class="vc-preloader"></div>
		</footer>
		<?php
		$staticHTMLCache = StaticHTMLCache::getInstance();
		$staticHTMLCache->disableVoting();
		$APPLICATION->IncludeComponent('bitrix:iblock.element.add.form', 'vd-callback-modal', [
			'CUSTOM_TITLE_DATE_ACTIVE_FROM' => '',
			'CUSTOM_TITLE_DATE_ACTIVE_TO' => '',
			'CUSTOM_TITLE_DETAIL_PICTURE' => '',
			'CUSTOM_TITLE_DETAIL_TEXT' => '',
			'CUSTOM_TITLE_IBLOCK_SECTION' => '',
			'CUSTOM_TITLE_NAME' => '',
			'CUSTOM_TITLE_PREVIEW_PICTURE' => '',
			'CUSTOM_TITLE_PREVIEW_TEXT' => '',
			'CUSTOM_TITLE_TAGS' => '',
			'DEFAULT_INPUT_SIZE' => '',
			'DETAIL_TEXT_USE_HTML_EDITOR' => 'N',
			'ELEMENT_ASSOC' => 'CREATED_BY',
			'GROUPS' => ['2'],
			'IBLOCK_ID' => Helper::getIblockIdByCode('vd-callback'),
			'IBLOCK_TYPE' => 'vd_forms',
			'LEVEL_LAST' => 'Y',
			'LIST_URL' => '',
			'MAX_FILE_SIZE' => '0',
			'MAX_LEVELS' => '100000',
			'MAX_USER_ENTRIES' => '100000',
			'PREVIEW_TEXT_USE_HTML_EDITOR' => 'N',
			'PROPERTY_CODES' => array_merge(['NAME'], Helper::getPropertyIdByCode(Helper::getIblockIdByCode('vd-callback'), ['NAME', 'PHONE'])),
			'PROPERTY_CODES_REQUIRED' => array_merge(['NAME'], Helper::getPropertyIdByCode(Helper::getIblockIdByCode('vd-callback'), ['NAME', 'PHONE'])),
			'RESIZE_IMAGES' => 'N',
			'SEF_MODE' => 'N',
			'STATUS' => 'ANY',
			'STATUS_NEW' => 'N',
			'USER_MESSAGE_ADD' => Loc::getMessage('VC_FORM_SUCCESS_TEXT'),
			'USER_MESSAGE_EDIT' => '',
			'USE_CAPTCHA' => 'N',
			'AGREEMENT_PAGE' => SITE_DIR.'about/privacy-policy/'
		]);
        $APPLICATION->IncludeComponent('bitrix:iblock.element.add.form', 'vd-doctor-home-modal', [
            'CUSTOM_TITLE_DATE_ACTIVE_FROM' => '',
            'CUSTOM_TITLE_DATE_ACTIVE_TO' => '',
            'CUSTOM_TITLE_DETAIL_PICTURE' => '',
            'CUSTOM_TITLE_DETAIL_TEXT' => '',
            'CUSTOM_TITLE_IBLOCK_SECTION' => '',
            'CUSTOM_TITLE_NAME' => '',
            'CUSTOM_TITLE_PREVIEW_PICTURE' => '',
            'CUSTOM_TITLE_PREVIEW_TEXT' => '',
            'CUSTOM_TITLE_TAGS' => '',
            'DEFAULT_INPUT_SIZE' => '',
            'DETAIL_TEXT_USE_HTML_EDITOR' => 'N',
            'ELEMENT_ASSOC' => 'CREATED_BY',
            'GROUPS' => ['2'],
            'IBLOCK_ID' => Helper::getIblockIdByCode('vd-doctor-home'),
            'IBLOCK_TYPE' => 'vd_forms',
            'LEVEL_LAST' => 'Y',
            'LIST_URL' => '',
            'MAX_FILE_SIZE' => '0',
            'MAX_LEVELS' => '100000',
            'MAX_USER_ENTRIES' => '100000',
            'PREVIEW_TEXT_USE_HTML_EDITOR' => 'N',
            'PROPERTY_CODES' => array_merge(['NAME', 'DETAIL_TEXT'], Helper::getPropertyIdByCode(Helper::getIblockIdByCode('vd-doctor-home'), ['NAME', 'PHONE', 'ADDRESS'])),
            'PROPERTY_CODES_REQUIRED' => array_merge(['NAME'], Helper::getPropertyIdByCode(Helper::getIblockIdByCode('vd-doctor-home'), ['NAME', 'PHONE'])),
            'RESIZE_IMAGES' => 'N',
            'SEF_MODE' => 'N',
            'STATUS' => 'ANY',
            'STATUS_NEW' => 'N',
            'USER_MESSAGE_ADD' => Loc::getMessage('VC_FORM_SUCCESS_TEXT'),
            'USER_MESSAGE_EDIT' => '',
            'USE_CAPTCHA' => 'N',
            'AGREEMENT_PAGE' => SITE_DIR.'about/privacy-policy/'
        ]);
        $APPLICATION->IncludeComponent('bitrix:iblock.element.add.form', 'vd-review', [
            'CUSTOM_TITLE_DATE_ACTIVE_FROM' => '',
            'CUSTOM_TITLE_DATE_ACTIVE_TO' => '',
            'CUSTOM_TITLE_DETAIL_PICTURE' => '',
            'CUSTOM_TITLE_DETAIL_TEXT' => '',
            'CUSTOM_TITLE_IBLOCK_SECTION' => '',
            'CUSTOM_TITLE_NAME' => '',
            'CUSTOM_TITLE_PREVIEW_PICTURE' => '',
            'CUSTOM_TITLE_PREVIEW_TEXT' => '',
            'CUSTOM_TITLE_TAGS' => '',
            'DEFAULT_INPUT_SIZE' => '',
            'DETAIL_TEXT_USE_HTML_EDITOR' => 'N',
            'ELEMENT_ASSOC' => 'CREATED_BY',
            'GROUPS' => ['2'],
            'IBLOCK_ID' => Helper::getIblockIdByCode('vd-reviews'),
            'IBLOCK_TYPE' => 'vd_reviews',
            'LEVEL_LAST' => 'Y',
            'LIST_URL' => '',
            'MAX_FILE_SIZE' => '0',
            'MAX_LEVELS' => '',
            'MAX_USER_ENTRIES' => '',
            'PREVIEW_TEXT_USE_HTML_EDITOR' => 'N',
            'PROPERTY_CODES' => array_merge(['NAME','DETAIL_TEXT'], Helper::getPropertyIdByCode(Helper::getIblockIdByCode('vd-reviews'), ['GRADE', 'NAME', 'MAIL'])),
            'PROPERTY_CODES_REQUIRED' => array_merge(['NAME','DETAIL_TEXT'], Helper::getPropertyIdByCode(Helper::getIblockIdByCode('vd-reviews'), ['NAME', 'MAIL'])),
            'RESIZE_IMAGES' => 'N',
            'SEF_MODE' => 'N',
            'STATUS' => 'ANY',
            'STATUS_NEW' => 'NEW',
            'USER_MESSAGE_ADD' => Loc::getMessage('VC_FORM_REVIEW_SUCCESS_TEXT'),
            'USER_MESSAGE_EDIT' => '',
            'USE_CAPTCHA' => 'N',
            'AGREEMENT_PAGE' => SITE_DIR.'about/privacy-policy/'
        ]);
		$staticHTMLCache->enableVoting();
        ?>

		<?= $GLOBALS['VD_SETTINGS']['counters']; ?>
	</body>
</html>
