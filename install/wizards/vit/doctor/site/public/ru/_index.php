<?php

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Вылечу нервные расстройства и верну качество жизни');
$APPLICATION->SetPageProperty('title', 'Персональный сайт врача Алексеева Григория Максимовича');

$arSections = ['main_banner', 'services', 'record', 'doctor', 'gallery', 'competencies', 'results', 'equipment', 'certificates', 'stages', 'questions', 'reviews', 'contacts'];
foreach ($arSections as $section) {
    $APPLICATION->IncludeFile(SITE_DIR.'includes/sections/'.$section.'.php', [], ['SHOW_BORDER' => false]);
}

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php'); ?>
