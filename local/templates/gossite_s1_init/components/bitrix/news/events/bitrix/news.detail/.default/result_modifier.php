<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$cp = $this->__component; // объект компонента

if (is_object($cp))
{
   // добавим в arResult компонента два пол€ - MY_TITLE и IS_OBJECT
   $cp->arResult['OGIMG'] = $arResult["PREVIEW_PICTURE"]["SRC"];
   $cp->SetResultCacheKeys(array('OGIMG'));
   // сохраним их в копии arResult, с которой работает шаблон
   $arResult['OGIMG'] = $cp->arResult['OGIMG'];
}

if(!empty($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTOS"]["VALUE"])){
    //делаю квадратные превью фотки и сохран€ю в кеш
    foreach($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTOS"]["VALUE"] as $arItem):
        $file_trumb = CFile::ResizeImageGet($arItem, array('width'=>350, 'height'=>265), BX_RESIZE_IMAGE_EXACT, true);                
        $file_large = CFile::ResizeImageGet($arItem, array('width'=>1300, 'height'=>800), BX_RESIZE_IMAGE_EXACT, true);                
        if(isset($file_trumb['src'])){
            $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTOS"]["DISPLAY_VALUE_SRC"][] = array("TRUMB"=>$file_trumb, "LARGE"=>$file_large);
        }
    endforeach;
}
