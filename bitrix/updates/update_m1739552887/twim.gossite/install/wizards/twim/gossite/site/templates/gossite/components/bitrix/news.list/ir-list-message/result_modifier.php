<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult["ITEMS"] as $key => $arItem){
    $arResult["ITEMS"][$key]["DISPLAY_PROPERTIES"]["DATE"]["DISPLAY_VALUE"] = ConvertDateTime($arResult["ITEMS"][$key]["DISPLAY_PROPERTIES"]["DATE"]["DISPLAY_VALUE"], "DD.MM.YYYY");
    $idPropsCat = $arItem["DISPLAY_PROPERTIES"]["CATEGORY"]["VALUE"];
    $arResult["ITEMS"][$key]["CATEGORY"] =  $arItem["DISPLAY_PROPERTIES"]["CATEGORY"]["LINK_SECTION_VALUE"][$idPropsCat]["NAME"];
    $idPropsEl = $arItem["DISPLAY_PROPERTIES"]["AGENCY"]["VALUE"];
    $arResult["ITEMS"][$key]["AGENCY"] =  $arItem["DISPLAY_PROPERTIES"]["AGENCY"]["LINK_ELEMENT_VALUE"][$idPropsEl]["NAME"];
}

