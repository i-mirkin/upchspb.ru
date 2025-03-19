<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(empty($arResult["DISPLAY_PROPERTIES"]["USER"]["DISPLAY_VALUE"])){
    $arResult["DISPLAY_PROPERTIES"]["USER"]["DISPLAY_VALUE"] = getMessage("QU_USER_ANONIM");
}
if(empty($arResult["DISPLAY_PROPERTIES"]["AUHTOR_ANSWER"]["DISPLAY_VALUE"])){
    $arResult["DISPLAY_PROPERTIES"]["AUHTOR_ANSWER"]["DISPLAY_VALUE"] = getMessage("QU_USER_ADMIN");
}
$arResult["DATE_CREATE"] = FormatDate("j F Y, H:i", MakeTimeStamp($arResult["DATE_CREATE"]));
$arResult["TIMESTAMP_X"] = FormatDate("j F Y, H:i", MakeTimeStamp($arResult["TIMESTAMP_X"]));
