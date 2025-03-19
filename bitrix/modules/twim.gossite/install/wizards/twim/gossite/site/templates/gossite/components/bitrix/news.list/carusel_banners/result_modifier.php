<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(count($arResult["ITEMS"]) > 17){ // 3 banner in col
    $arResult["FORMAT_ITEMS"] = array_chunk($arResult["ITEMS"], 3);
    $arResult["FORMAT_LINES"] = 3;
} elseif(count($arResult["ITEMS"]) > 9) { // 1 banner in col
    $arResult["FORMAT_ITEMS"] = array_chunk($arResult["ITEMS"], 2);
    $arResult["FORMAT_LINES"] = 2;
} else { // 1 banner in col
    $arResult["FORMAT_ITEMS"] = array_chunk($arResult["ITEMS"], 1);
    $arResult["FORMAT_LINES"] = 1;
}

