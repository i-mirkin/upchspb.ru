<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Загрузка фотографий");
$APPLICATION->SetTitle("Загрузка фотографий");?>
<?$APPLICATION->IncludeComponent(
	"twim:upload.photos", 
	".default", 
	array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"FILE_COUNT_MAX" => "20",
		"FILE_EXT" => "jpg, png, jpeg, bmp",
		"FILE_SIZE" => "5242880",
		"IBLOCK_ID" => "#PHOTOS_IBLOCK_ID#",
		"IBLOCK_TYPE" => "media",
		"USE_JQUERY" => "N",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
