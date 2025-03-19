<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
use Bitrix\Main\Localization\Loc;
$arOptionGosSite = $arParams["OPTION_SITE"];
?>


		<footer class="footer-top">
			<div class="footer__top">
				<div class="b-container">
					<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"footer_top", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_THEME" => "site",
		"ROOT_MENU_TYPE" => "footer_top",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "footer_top"
	),
	false
);?>
				</div>
			</div>
			<?if('s1' == SITE_ID) { ?>
			<div class="footer__center">
				<div class="b-container">
					<ul class="footer-menu2 ">
						<li class="footer-menu2__item footer-info">
							<div class="footer-info__title">Связаться</div>
							<?if($arOptionGosSite["phone"]):?>
							<div class="footer-info__tel"><a href="tel:<?=str_replace(' ','',$arOptionGosSite["phone"])?>"><?=$arOptionGosSite["phone"]?></a></div>
							<?endif;?>
							<?if($arOptionGosSite["address"]):?>
							<div class="footer-info__address"><?= $arOptionGosSite["address"] ?></div>
							<?endif;?>
							<?if($arOptionGosSite["email"]):?>
							<div class="footer-info__mail"><a href="mailto:<?=$arOptionGosSite["email"]?>"><?=$arOptionGosSite["email"]?></a></div>
							<?endif;?>
							<?$APPLICATION->IncludeComponent(
	"bquadro:sm.links", 
	"footer", 
	array(
		"youtube" => "",
		"facebook" => "https://www.facebook.com/HR.OmbudsmanforSt.Petersburg/",
		"vkontakte" => "https://vk.com",
		"instagram" => "https://www.instagram.com/?hl=ru",
		"telegram" => "https://tlgrm.ru/",
		"COMPONENT_TEMPLATE" => "footer"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?>
						</li>
											<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_THEME" => "site",
		"ROOT_MENU_TYPE" => "bottom",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "bottom"
	),
	false,
	array('HIDE_ICONS'=>'Y')
	);?>
								
					</ul>
						
				</div>
			</div>
			
			<div class="footer__special">
				<div class="b-container">
					<a href="#special" title="Включить версию для слабовидящих" class="special"><span class="sr-only">Версия для слабовидящих</span></a>
				</div>
			</div>
			<?}?>
			<div class="footer__bottom">
				<div class="b-container">
					<div class="footer__bottom-wr clearfix">
						<div class="footer__copyright">© <?=GetMessage('COPY_INFO');?></div>
					</div>
				</div>
			</div>
		</footer>

