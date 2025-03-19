<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Инфо");?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"detail-structure",
	Array(
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COUNT_ELEMENTS" => "N",
		"IBLOCK_ID" => "#STRUCTURE_IBLOCK_ID#",
		"IBLOCK_TYPE" => "structure",
		"SECTION_CODE" => $_REQUEST["CODE"],
		"SECTION_FIELDS" => array("DESCRIPTION",""),
		"SECTION_ID" => "",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array("",""),
		"SHOW_PARENT_NAME" => "N",
		"TOP_DEPTH" => "1",
		"VIEW_MODE" => "LINE"
	)
);?><br>
 <br>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>