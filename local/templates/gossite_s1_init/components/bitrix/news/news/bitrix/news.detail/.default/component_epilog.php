<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// init meta soc net
global $APPLICATION;
$APPLICATION->SetPageProperty("og:url", $arResult["CANONICAL_PAGE_URL"]); // url
$APPLICATION->SetPageProperty("og:title", $arResult["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"]); // название
$APPLICATION->SetPageProperty("og:description",  $arResult["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"]); // описание
if(!empty($arResult["OGIMG"])):
    $APPLICATION->SetPageProperty("og:image",  $arResult["OGIMG"]);
endif;
