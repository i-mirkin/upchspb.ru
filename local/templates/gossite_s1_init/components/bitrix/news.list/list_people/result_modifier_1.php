<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult["ITEMS"] as &$arItem):
    $file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']["ID"], array('width'=>$arParams["WIDTH_PREV_IMG"], 'height'=>$arParams["HEIGHT_PREV_IMG"]), BX_RESIZE_IMAGE_EXACT, true);                
    if(isset($file['src'])){
        $arItem['PREVIEW_PICTURE']["SRC_RE"] = $file['src'];
    } else{
        $arItem['PREVIEW_PICTURE']["SRC_RE"] = $arItem['PREVIEW_PICTURE']["SRC"];
    }
endforeach;
