<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Запись на прием");
$APPLICATION->SetTitle("Запись на прием");
?>




<?$APPLICATION->IncludeComponent("bitrix:main.include", "template1", Array(
	"AREA_FILE_SHOW" => "sect",	// Показывать включаемую область
		"AREA_FILE_SUFFIX" => "inc",	// Суффикс имени файла включаемой области
		"AREA_FILE_RECURSIVE" => "Y",	// Рекурсивное подключение включаемых областей разделов
		"EDIT_TEMPLATE" => "standard.php",	// Шаблон области по умолчанию
	),
	false
);?>

<?
// \local\components\bquadro\appointment\templates\.default\template.php
$APPLICATION->IncludeComponent(
	"bquadro:appointment",
	".default",
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID" => "37",
		"IBLOCK_ID_DATE" => "40",
		"IBLOCK_ID_HOURS" => "37",
		"IBLOCK_ID_RECORD" => "39",
		"IBLOCK_ID_SCHEDULE" => "41",
		"IBLOCK_ID_THEME" => "38",
		"IBLOCK_TYPE" => "appointment",
		"SECTION_URL" => "/appointment/",
		"USE_CAPTCHA" => "Y",
		
	),
	false
);?>







<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>