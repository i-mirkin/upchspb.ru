<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// init meta soc net
global $APPLICATION;
$APPLICATION->SetPageProperty("og:url", $arResult["CANONICAL_PAGE_URL"]); // url
$APPLICATION->SetPageProperty("og:title", $arResult["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"]);
// $APPLICATION->SetPageProperty("og:description",  strip_tags($arResult["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"])); 
if(isset($templateData['META_DESC']) && !empty($templateData['META_DESC'])) {
    $APPLICATION->SetPageProperty("description", strip_tags($templateData['META_DESC'])); 
    $APPLICATION->SetPageProperty("og:description", strip_tags($templateData['META_DESC']));  
}
if(!empty($arResult["OGIMG"])):
    $APPLICATION->SetPageProperty("og:image",  $arResult["OGIMG"]);
endif;
