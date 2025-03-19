<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

use \Bitrix\Main\Loader;

$arFilter = array(
	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
);
if (0 < intval($arResult["VARIABLES"]["ELEMENT_ID"]))
	$arFilter["ID"] = $arResult["VARIABLES"]["ELEMENT_ID"];
elseif ('' != $arResult["VARIABLES"]["ELEMENT_CODE"])
	$arFilter["=CODE"] = $arResult["VARIABLES"]["ELEMENT_CODE"];

$obCache = new CPHPCache();
if ($obCache->InitCache(36000, serialize($arFilter), "/bquadro/news"))
{
	$arCurElement = $obCache->GetVars();
}
elseif ($obCache->StartDataCache())
{
	$arCurElement = array();
	if (Loader::includeModule("iblock"))
	{
		$dbRes = CIBlockElement::GetList(array("ID"=>"ASC"), $arFilter, false, false, array("ID", "DETAIL_PAGE_URL"));
		$dbRes->SetUrlTemplates($arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"]);

		if(defined("BX_COMP_MANAGED_CACHE"))
		{
			global $CACHE_MANAGER;
			$CACHE_MANAGER->StartTagCache("/bquadro/news");

			if ($arCurElement = $dbRes->GetNext())
				$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

			$CACHE_MANAGER->EndTagCache();
		}
		else
		{
			if(!$arCurElement = $dbRes->GetNext())
				$arCurElement = array();
		}
	}
	$obCache->EndDataCache($arCurElement);
}
if (!isset($arCurElement))
	$arCurElement = array();

if ($arCurElement["ID"] > 0)
	$_REQUEST["CODE"] = $arCurElement["ID"];
?>
<?$APPLICATION->IncludeComponent(
	"bquadro:competition.add.form", 
	"edit", 
	array(
		"ACTION_VARIABLE" => "soa-action",
		"COMPONENT_TEMPLATE" => "edit",
		"CUSTOM_TITLE_CARROT_DETAIL_PICTURE" => "",
		"CUSTOM_TITLE_CARROT_HEIGHT" => "",
		"CUSTOM_TITLE_CARROT_PREVIEW_PICTURE" => "",
		"CUSTOM_TITLE_CARROT_UNIQUE_DATE_ID" => "",
		"CUSTOM_TITLE_CARROT_WEIGHT" => "",
		"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "Срок соревнования, от",
		"CUSTOM_TITLE_DATE_ACTIVE_TO" => "Срок соревнования, до",
		"CUSTOM_TITLE_DETAIL_PICTURE" => "",
		"CUSTOM_TITLE_DETAIL_TEXT" => "",
		"CUSTOM_TITLE_IBLOCK_SECTION" => "",
		"CUSTOM_TITLE_NAME" => "",
		"CUSTOM_TITLE_PREVIEW_PICTURE" => "",
		"CUSTOM_TITLE_PREVIEW_TEXT" => "",
		"CUSTOM_TITLE_TAGS" => "",
		"DEFAULT_INPUT_SIZE" => "30",
		"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
		"ELEMENT_ASSOC" => "CREATED_BY",
		"ELEMENT_ASSOC_PROPERTY" => "74",
		"GROUPS" => array(
			0 => "6",
		),
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "catalog",
		"IS_STEPS" => "N",
		"LEVEL_LAST" => "Y",
		"LIST_BLOCKS_STEP_ORDER" => "step_1,step_2,step_3,step_4",
		"LIST_URL" => "",
		"MAX_FILE_SIZE" => "0",
		"MAX_LEVELS" => "100000",
		"MAX_USER_ENTRIES" => "100000",
		"ORDER_PROP" => "PREVIEW_PICTURE,14,NAME,23,DATE_ACTIVE_FROM,75,15,DATE_ACTIVE_TO,24,19,PREVIEW_TEXT,CARROT_WEIGHT,CARROT_HEIGHT,CARROT_PREVIEW_PICTURE,CARROT_DETAIL_PICTURE,CARROT_UNIQUE_DATE_ID,DETAIL_TEXT,TAGS,IBLOCK_SECTION,DETAIL_PICTURE,78,79,81,82,83,84",
		"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
		"PROPERTY_CODES" => array(
			0 => "15",
			1 => "23",
			2 => "24",
			3 => "75",
			4 => "NAME",
			5 => "DATE_ACTIVE_TO",
			6 => "PREVIEW_PICTURE",
		),
		"PROPERTY_CODES_REQUIRED" => array(
			0 => "23",
			1 => "NAME",
		),
		"PROPERTY_CODES_STEP_1" => array(
			0 => "13",
			1 => "14",
			2 => "15",
			3 => "NAME",
			4 => "DATE_ACTIVE_FROM",
			5 => "DATE_ACTIVE_TO",
			6 => "PREVIEW_PICTURE",
		),
		"PROPERTY_CODES_STEP_2" => array(
			0 => "23",
			1 => "CARROT_WEIGHT",
			2 => "CARROT_PREVIEW_PICTURE",
			3 => "CARROT_DETAIL_PICTURE",
			4 => "CARROT_UNIQUE_DATE_ID",
		),
		"PROPERTY_CODES_STEP_3" => array(
			0 => "24",
			1 => "PREVIEW_TEXT",
		),
		"PROPERTY_CODES_STEP_4" => "",
		"RESIZE_IMAGES" => "N",
		"SEF_MODE" => "N",
		"STATUS" => "ANY",
		"STATUS_NEW" => "N",
		"USER_MESSAGE_ADD" => "Соревнование успешно добавлено",
		"USER_MESSAGE_EDIT" => "Соревнование успешно сохранено",
		"USE_CAPTCHA" => "N"
	),
	false
);?>