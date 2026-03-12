<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
CHTTP::SetStatus('404 Not Found');
@define('ERROR_404', 'Y');
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Страница не найдена');
$APPLICATION->SetPageProperty('title', 'Страница не найдена');
?>

<div class="vc-not-found">
    <div class="vc-center">
        <div class="vc-not-found__container">
            <div class="vc-not-found__content">
                <div class="vc-not-found__info">
                    <div class="vc-not-found__title">Страница не найдена</div>
                    <div class="vc-not-found__text">К сожалению, не удалось найти такую страницу.</div>
                    <div class="vc-not-found__btn">
                        <a href="<?= SITE_DIR; ?>" class="vc-btn">На главную</a>
                    </div>
                </div>
                <div class="vc-not-found__image">
                    <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/assets/img/not-found/image.svg'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php'); ?>
