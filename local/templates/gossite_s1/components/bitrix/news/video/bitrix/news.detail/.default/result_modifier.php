<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//получаем id видео
if(!empty($arResult["DISPLAY_PROPERTIES"]["LINK_YOUTUBE"]["VALUE"])){
    $url_video = $arResult["DISPLAY_PROPERTIES"]["LINK_YOUTUBE"]["VALUE"];
    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url_video, $match)) {
        $v = $match[1];
    }  
    if(!empty($v)){
        $arResult["VIDEO"]["ID"]  = $v;
    }
}
