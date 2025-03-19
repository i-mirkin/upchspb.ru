<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach($arResult["ITEMS"] as $key => $arItem){
    if(empty($arItem["DISPLAY_PROPERTIES"]["USER"]["DISPLAY_VALUE"])){
        $arResult["ITEMS"][$key]["DISPLAY_PROPERTIES"]["USER"]["DISPLAY_VALUE"] = getMessage("QU_USER_ANONIM");
    }
    
    if(empty($arItem["DISPLAY_PROPERTIES"]["AUHTOR_ANSWER"]["DISPLAY_VALUE"])){
        $arResult["ITEMS"][$key]["DISPLAY_PROPERTIES"]["AUHTOR_ANSWER"]["DISPLAY_VALUE"] = getMessage("QU_USER_ADMIN");
    }
    $arResult["ITEMS"][$key]["DATE_CREATE"] = FormatDate("j F Y, H:i", MakeTimeStamp($arItem["DATE_CREATE"]));
    $arResult["ITEMS"][$key]["TIMESTAMP_X"] = FormatDate("j F Y, H:i", MakeTimeStamp($arItem["TIMESTAMP_X"]));
    
}