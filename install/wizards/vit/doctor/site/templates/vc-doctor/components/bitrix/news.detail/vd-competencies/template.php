<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>

<?php if (isset($arResult['ID']) && (isset($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']) || isset($arResult['DISPLAY_PROPERTIES']['EDUCATION']) || isset($arResult['DISPLAY_PROPERTIES']['EXPERIENCE']))): ?>
	<div class="vc-section  vc-section--p32" id="data">
		<div class="vc-center">
			<div class="vc-section__content">
				<div class="vc-details">
					<div class="vc-details__header  swiper-container">
						<div class="vc-details__tabs  swiper-wrapper">
                            <?php if (isset($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION'])): ?>
                                <div class="vc-details__tab  swiper-slide<?php if ($arResult['ACTIVE_TAB'] == 'SPECIALIZATION'): ?>  vc-details__tab--active<?php endif; ?>" data-name="specs"><?= Loc::getMessage('VD_COMPETENCIES_SPECIALIZATION'); ?></div>
                            <?php endif; ?>
                            <?php if (isset($arResult['DISPLAY_PROPERTIES']['EDUCATION'])): ?>
                                <div class="vc-details__tab  swiper-slide<?php if ($arResult['ACTIVE_TAB'] == 'EDUCATION'): ?>  vc-details__tab--active<?php endif; ?>" data-name="education"><?= Loc::getMessage('VD_COMPETENCIES_EDUCATION'); ?></div>
                            <?php endif; ?>
                            <?php if (isset($arResult['DISPLAY_PROPERTIES']['EXPERIENCE'])): ?>
                                <div class="vc-details__tab  swiper-slide<?php if ($arResult['ACTIVE_TAB'] == 'EXPERIENCE'): ?>  vc-details__tab--active<?php endif; ?>" data-name="experience"><?= Loc::getMessage('VD_COMPETENCIES_EXPERIENCE'); ?></div>
                            <?php endif; ?>
						</div>
					</div>
					<?php if (isset($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION'])): ?>
						<div class="vc-details__content<?php if ($arResult['ACTIVE_TAB'] == 'SPECIALIZATION'): ?>  vc-details__content--active<?php endif; ?>" data-name="specs">
							<?php foreach ($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']['FORMATTED'] as $title => $arSpecialization): ?>
								<div class="vc-details__list">
									<?php if ($arResult['DISPLAY_PROPERTIES']['SPECIALIZATION']['HIDE_TITLE'] != 'Y'): ?>
										<div class="vc-details__list-title"><?= $title; ?></div>
									<?php endif; ?>
									<?php foreach ($arSpecialization as $service): ?>
										<div class="vc-details__list-item">
											<div class="vc-details__list-item-icon">
												<?= file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/img/details/check.svg'); ?>
											</div>
											<div class="vc-details__list-item-text"><?= $service; ?></div>
										</div>
									<?php endforeach; ?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<?php if (isset($arResult['DISPLAY_PROPERTIES']['EDUCATION'])): ?>
						<div class="vc-details__content<?php if ($arResult['ACTIVE_TAB'] == 'EDUCATION'): ?>  vc-details__content--active<?php endif; ?>" data-name="education">
							<div class="vc-details__timeframes">
								<?php foreach ($arResult['DISPLAY_PROPERTIES']['EDUCATION']['FORMATTED'] as $arEducation): ?>
									<div class="vc-details__timeframe">
										<div class="vc-details__timeframe-years"><?= $arEducation['DATES']; ?></div>
										<div class="vc-details__timeframe-content">
											<div class="vc-details__timeframe-title"><?= $arEducation['TITLE']; ?></div>
											<div class="vc-details__timeframe-subtitle"><?= $arEducation['DESCRIPTION']; ?></div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
					<?php if (isset($arResult['DISPLAY_PROPERTIES']['EXPERIENCE'])): ?>
						<div class="vc-details__content<?php if ($arResult['ACTIVE_TAB'] == 'EXPERIENCE'): ?>  vc-details__content--active<?php endif; ?>" data-name="experience">
							<div class="vc-details__timeframes">
								<?php foreach ($arResult['DISPLAY_PROPERTIES']['EXPERIENCE']['FORMATTED'] as $arExperience): ?>
									<div class="vc-details__timeframe  vc-details__timeframe--wide">
										<div class="vc-details__timeframe-years"><?= $arExperience['DATES']; ?></div>
										<div class="vc-details__timeframe-content">
											<div class="vc-details__timeframe-title"><?= $arExperience['TITLE']; ?></div>
											<div class="vc-details__timeframe-subtitle"><?= $arExperience['DESCRIPTION']; ?></div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
