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
?>

<?
$tagId = '';
$obCache = new CPHPCache();
if( $obCache->InitCache('36000','tag_'.$arResult['VARIABLES']['ELEMENT_CODE']) )// Если кэш валиден
{
   $arr = $obCache->GetVars();// Извлечение переменных из кэша
   $tagId = $arr['tagId'];
   $tagName = $arr['tagName'];
}
elseif( $obCache->StartDataCache()  )// Если кэш невалиден
{
	
	$arFilterTag = Array(
		"IBLOCK_ID"=>31,
		"ACTIVE"=>"Y", 
		"CODE"=>$arResult['VARIABLES']['ELEMENT_CODE']
	);
	$resTag = CIBlockElement::GetList(Array(), $arFilterTag);
	while($ar_fieldsTag = $resTag->GetNext())
	{
		$tagId = $ar_fieldsTag['ID'];
		$tagName = $ar_fieldsTag['NAME'];
	}
	$obCache->EndDataCache(["tagId" => $tagId, 'tagName'=>$tagName]);   
}


?>


<?
	global $arrFilter;
	$arrFilter = [];
	if($tagId) $arrFilter['PROPERTY_TAG_LINK'] = $tagId;
?>
<?$APPLICATION->IncludeComponent(
	"bquadro:news.list.select", 
	"tag", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "news",
		"IBLOCKS" => array(
			0 => "",
			1 => $_REQUEST["ID"],
			2 => "",
		),
		"NEWS_COUNT" => "",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"SORT_BY3" => "SORT",
		"SORT_ORDER3" => "ASC",
		"FILTER_NAME" => "arrFilter",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?>
<?
	$APPLICATION->SetPageProperty("title",$tagName);
	$APPLICATION->AddChainItem($tagName);
?>
