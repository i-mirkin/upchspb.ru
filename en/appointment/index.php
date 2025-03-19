<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Make an appointment");
$APPLICATION->SetTitle("Make an appointment");
?><?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
	"AREA_FILE_SHOW" => "sect", 
	"AREA_FILE_SUFFIX" => "inc", 
	"AREA_FILE_RECURSIVE" => "Y", 
	"EDIT_TEMPLATE" => "standard.php" 
)
);?>
<?$APPLICATION->IncludeComponent(
	"bquadro:appointment", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID" => "37",
		"IBLOCK_ID_DATE" => "40",
		"IBLOCK_ID_HOURS" => "44",
		"IBLOCK_ID_RECORD" => "47",
		"IBLOCK_ID_SCHEDULE" => "46",
		"IBLOCK_ID_THEME" => "45",
		"IBLOCK_TYPE" => "appointmentEN"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>