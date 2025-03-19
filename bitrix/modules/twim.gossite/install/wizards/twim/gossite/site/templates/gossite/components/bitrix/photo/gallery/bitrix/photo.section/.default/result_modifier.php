<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult["ITEMS"] as &$arItem):
    $file = CFile::ResizeImageGet($arItem['PICTURE']["ID"], array('width'=>410, 'height'=>230), BX_RESIZE_IMAGE_EXACT, true);                
    if(isset($file['src'])){
        $arItem['PICTURE']["SRC_RE"] = $file['src'];
    }
endforeach;
