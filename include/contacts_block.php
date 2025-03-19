<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arOptionGosSite = $arParams["OPTION_SITE"];?>
<div class="wrap-main-contacts">
	 <?if(!empty($arOptionGosSite["api_map_key_ya"]) && !empty($arOptionGosSite["coord_ya"])):?> <?$APPLICATION->IncludeComponent(
	"twim:system.empty",
	"ya_map",
	Array(
		"CACHE_TIME" => "360000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "ya_map",
		"PARAM1" => "",
		"PARAM2" => "1",
		"TITLE" => ""
	),
false,
Array(
	'HIDE_ICONS' => 'Y'
)
);?> <?endif;?>
	<div class="main-contacts-map">
		 <script type="text/javascript" data-skip-moving="true" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A2e6e3fce512f5abdffe6c6ae5562a09281413795b6c4b4bfc2911590a123db4c&amp;width=100%25&amp;height=300&amp;lang=ru_RU&amp;scroll=true"></script>
	</div>
	<div class="main-contacts">
		<div class="wrap-text">
			<h5><?
                $APPLICATION->IncludeFile(
                    SITE_DIR."include/title-site.php",
                    Array(),
                    Array("MODE"=>"text", "SHOW_BORDER" => false)
                );
                ?> </h5>
 <br>
			 <?if(!empty($arOptionGosSite["post_boss"])):?>
			<p>
 <small><?=$arOptionGosSite["post_boss"]?></small>
			</p>
			 <?endif;?> <?if(!empty($arOptionGosSite["fio_boss"])):?>
			<p>
				 <?=$arOptionGosSite["fio_boss"]?>
			</p>
 <br>
			 <?endif;?>
			<p>
 <small></small>
			</p>
 <address>
			<?if(!empty($arOptionGosSite["address"])):?> <?=$arOptionGosSite["address"]?><br>
			 <?endif;?> <?if(!empty($arOptionGosSite["phone"])):?> <?=$arOptionGosSite["phone"]?><br>
			 <?endif;?> <?=$arOptionGosSite["email"]?> </address>
			<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_RECURSIVE" => "Y",
		"AREA_FILE_SHOW" => "sect",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "standard.php"
	)
);?>
		</div>
	</div>
</div>
 <br>