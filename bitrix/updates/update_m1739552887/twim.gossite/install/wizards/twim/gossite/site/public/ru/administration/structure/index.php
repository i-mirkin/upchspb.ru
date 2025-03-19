<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Структура администрации");
$APPLICATION->SetTitle("Структура администрации");
$APPLICATION->SetPageProperty("page_one_column", "Y");
?><?$APPLICATION->IncludeComponent(
	"twim:structure.visual", 
	".organizational-chart", 
	array(
		"IBLOCK_ID" => "#STRUCTURE_IBLOCK_ID#",
		"IBLOCK_TYPE" => "structure",
		"COMPONENT_TEMPLATE" => ".organizational-chart"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
