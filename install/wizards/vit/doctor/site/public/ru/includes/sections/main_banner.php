<?php

use Vit\Doctor\Helper;

?>

<div class="vc-home-bnr">
    <div class="vc-center">
        <div class="vc-home-bnr__wrapper">
            <div class="vc-home-bnr__content">
                <h1 class="vc-home-bnr__title"><?php $APPLICATION->ShowTitle(false); ?></h1>
                <div class="vc-home-bnr__btn">
                    <a href="#record" class="vc-btn">Записаться на консультацию</a>
                </div>
                <?php $APPLICATION->IncludeComponent('bitrix:news.list', 'vd-advantages', [
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
                    'IBLOCK_ID' => Helper::getIblockIdByCode('vd-advantages'),
                    'IBLOCK_TYPE' => 'vd_content',
                    'INCLUDE_IBLOCK_INTO_CHAIN' => 'N',
                    'INCLUDE_SUBSECTIONS' => 'Y',
                    'MESSAGE_404' => '',
                    'NEWS_COUNT' => '3',
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
                    'PROPERTY_CODE' => ['ICON'],
                    'QUESTION_TITLE' => '',
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
            </div>
            <?php $APPLICATION->IncludeFile(SITE_DIR.'includes/banner/images.inc.php', [], [
                'SHOW_BORDER' => 'true',
                'MODE' => 'text'
            ]);	?>
        </div>
    </div>
</div>