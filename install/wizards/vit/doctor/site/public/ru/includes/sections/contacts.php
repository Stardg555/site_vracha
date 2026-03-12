<?php

use Vit\Doctor\Helper;

?>

<div class="vc-section"  id="contacts">
    <div class="vc-branches">
        <div class="vc-center">
            <div class="vc-branches__main">
                <div class="vc-branches__map-wrapper">
                    <?php $APPLICATION->IncludeComponent('bitrix:news.list', 'vd-addresses', [
                        'ACTIVE_DATE_FORMAT' => '',
                        'ADD_SECTIONS_CHAIN' => 'N',
                        'AJAX_MODE' => 'N',
                        'AJAX_OPTION_ADDITIONAL' => '',
                        'AJAX_OPTION_HISTORY' => 'N',
                        'AJAX_OPTION_JUMP' => 'N',
                        'AJAX_OPTION_STYLE' => 'N',
                        'CACHE_FILTER' => 'N',
                        'CACHE_GROUPS' => 'N',
                        'CACHE_TIME' => '36000000',
                        'CACHE_TYPE' => 'A',
                        'CHECK_DATES' => 'Y',
                        'DETAIL_URL' => '',
                        'DISPLAY_BOTTOM_PAGER' => 'N',
                        'DISPLAY_DATE' => 'N',
                        'DISPLAY_NAME' => 'Y',
                        'DISPLAY_PICTURE' => 'Y',
                        'DISPLAY_PREVIEW_TEXT' => 'N',
                        'DISPLAY_TOP_PAGER' => 'N',
                        'FIELD_CODE' => [],
                        'FILTER_NAME' => '',
                        'HIDE_LINK_WHEN_NO_DETAIL' => 'N',
                        'IBLOCK_ID' => Helper::getIblockIdByCode('vd-addresses'),
                        'IBLOCK_TYPE' => 'vd_contacts',
                        'INCLUDE_IBLOCK_INTO_CHAIN' => 'N',
                        'INCLUDE_SUBSECTIONS' => 'Y',
                        'MESSAGE_404' => '',
                        'NEWS_COUNT' => '10',
                        'PAGER_BASE_LINK_ENABLE' => 'N',
                        'PAGER_DESC_NUMBERING' => 'N',
                        'PAGER_DESC_NUMBERING_CACHE_TIME' => '',
                        'PAGER_SHOW_ALL' => 'N',
                        'PAGER_SHOW_ALWAYS' => 'N',
                        'PAGER_TEMPLATE' => '',
                        'PAGER_TITLE' => '',
                        'PARENT_SECTION' => '',
                        'PARENT_SECTION_CODE' => '',
                        'PREVIEW_TRUNCATE_LEN' => '',
                        'PROPERTY_CODE' => ['COORDINATES'],
                        'SET_BROWSER_TITLE' => 'N',
                        'SET_LAST_MODIFIED' => 'N',
                        'SET_META_DESCRIPTION' => 'N',
                        'SET_META_KEYWORDS' => 'N',
                        'SET_STATUS_404' => 'N',
                        'SET_TITLE' => 'N',
                        'SHOW_404' => 'N',
                        'SORT_BY1' => 'SORT',
                        'SORT_BY2' => 'NAME',
                        'SORT_ORDER1' => 'ASC',
                        'SORT_ORDER2' => 'ASC',
                        'STRICT_SECTION_CHECK' => 'N',
                        'MAP_CENTER' => '55.757217,37.571193',
                        'MAP_MOBILE_CENTER' => '55.807217,37.601193',
                        'ZOOM' => '12',
                        'ZOOM_MOBILE' => '10',
                        'ZOOM_ACTIVE' => '16'
                    ]); ?>
                </div>
                <div class="vc-branches__contacts">
                    <?php $APPLICATION->IncludeFile(SITE_DIR.'includes/contacts/phone.inc.php', [], [
                        'SHOW_BORDER' => 'true',
                        'MODE' => 'text'
                    ]);	?>
                    <?php $APPLICATION->IncludeFile(SITE_DIR.'includes/contacts/email.inc.php', [], [
                        'SHOW_BORDER' => 'true',
                        'MODE' => 'text'
                    ]);	?>
                    <?php $APPLICATION->IncludeFile(SITE_DIR.'includes/contacts/address.inc.php', [], [
                        'SHOW_BORDER' => 'true',
                        'MODE' => 'text'
                    ]);	?>
                    <?php $APPLICATION->IncludeComponent('bitrix:news.list', 'vd-socials', [
                        'ACTIVE_DATE_FORMAT' => '',
                        'ADD_SECTIONS_CHAIN' => 'N',
                        'AJAX_MODE' => 'N',
                        'AJAX_OPTION_ADDITIONAL' => '',
                        'AJAX_OPTION_HISTORY' => 'N',
                        'AJAX_OPTION_JUMP' => 'N',
                        'AJAX_OPTION_STYLE' => 'N',
                        'CACHE_FILTER' => 'N',
                        'CACHE_GROUPS' => 'N',
                        'CACHE_TIME' => '36000000',
                        'CACHE_TYPE' => 'A',
                        'CHECK_DATES' => 'Y',
                        'DETAIL_URL' => '',
                        'DISPLAY_BOTTOM_PAGER' => 'N',
                        'DISPLAY_DATE' => 'N',
                        'DISPLAY_NAME' => 'Y',
                        'DISPLAY_PICTURE' => 'N',
                        'DISPLAY_PREVIEW_TEXT' => 'N',
                        'DISPLAY_TOP_PAGER' => 'N',
                        'FIELD_CODE' => [],
                        'FILTER_NAME' => '',
                        'HIDE_LINK_WHEN_NO_DETAIL' => 'N',
                        'IBLOCK_ID' => Helper::getIblockIdByCode('vd-socials'),
                        'IBLOCK_TYPE' => 'vd_content',
                        'INCLUDE_IBLOCK_INTO_CHAIN' => 'N',
                        'INCLUDE_SUBSECTIONS' => 'N',
                        'MESSAGE_404' => '',
                        'NEWS_COUNT' => '4',
                        'PAGER_BASE_LINK_ENABLE' => 'N',
                        'PAGER_DESC_NUMBERING' => 'N',
                        'PAGER_DESC_NUMBERING_CACHE_TIME' => '',
                        'PAGER_SHOW_ALL' => 'N',
                        'PAGER_SHOW_ALWAYS' => 'N',
                        'PAGER_TEMPLATE' => '',
                        'PAGER_TITLE' => '',
                        'PARENT_SECTION' => '',
                        'PARENT_SECTION_CODE' => '',
                        'PREVIEW_TRUNCATE_LEN' => '',
                        'PROPERTY_CODE' => ['SOCIAL', 'LINK'],
                        'SET_BROWSER_TITLE' => 'N',
                        'SET_LAST_MODIFIED' => 'N',
                        'SET_META_DESCRIPTION' => 'N',
                        'SET_META_KEYWORDS' => 'N',
                        'SET_STATUS_404' => 'N',
                        'SET_TITLE' => 'N',
                        'SHOW_404' => 'N',
                        'SORT_BY1' => 'SORT',
                        'SORT_BY2' => '',
                        'SORT_ORDER1' => 'ASC',
                        'SORT_ORDER2' => '',
                        'STRICT_SECTION_CHECK' => 'N'
                    ]); ?>
                    <div class="vc-branches__contact-btn">
                        <div class="vc-btn  js-open-modal" data-name="callbackModal">Заказать обратный звонок</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
