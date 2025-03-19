<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// форматирование даты обращения
$arResult["DISPLAY_PROPERTIES"]["DATE"]["DISPLAY_VALUE"] = ConvertDateTime($arResult["ITEMS"][$key]["DISPLAY_PROPERTIES"]["DATE"]["DISPLAY_VALUE"], "DD.MM.YYYY");
// получение категории органа власти
$idPropsCat = $arResult["DISPLAY_PROPERTIES"]["CATEGORY"]["VALUE"];
$arResult["DISPLAY_PROPERTIES"]["CATEGORY"]["DISPLAY_VALUE"] =  $arResult["DISPLAY_PROPERTIES"]["CATEGORY"]["LINK_SECTION_VALUE"][$idPropsCat]["NAME"];
// получение органа власти
$idPropsEl = $arResult["DISPLAY_PROPERTIES"]["AGENCY"]["VALUE"];
$arResult["DISPLAY_PROPERTIES"]["AGENCY"]["DISPLAY_VALUE"] =  $arResult["DISPLAY_PROPERTIES"]["AGENCY"]["LINK_ELEMENT_VALUE"][$idPropsEl]["NAME"];
// форматирование соавторов
if(is_array($arResult["DISPLAY_PROPERTIES"]["COAUTHOR"]["DISPLAY_VALUE"])){
    $listCoauthors = implode(", ", $arResult["DISPLAY_PROPERTIES"]["COAUTHOR"]["DISPLAY_VALUE"]);
} else {
    $listCoauthors = $arResult["DISPLAY_PROPERTIES"]["COAUTHOR"]["DISPLAY_VALUE"];
}
$arResult["DISPLAY_PROPERTIES"]["COAUTHOR"]["DISPLAY_VALUE"]  = strip_tags($listCoauthors);

