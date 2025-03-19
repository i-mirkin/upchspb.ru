<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult["ITEMS"] as &$arItem){
    $url_video = $arItem["DISPLAY_PROPERTIES"]["LINK_YOUTUBE"]["VALUE"];
    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url_video, $match)) {
        $v = $match[1];
    }
    if(is_array($arItem["PREVIEW_PICTURE"])){
        $file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>720, 'height'=>405), BX_RESIZE_IMAGE_EXACT, true);  
        if(isset($file['src'])){
            $arItem["PREVIEW_PICTURE"]["SRC"] = $file['src'];
        }
    }
    if(!is_array($arItem["PREVIEW_PICTURE"]) && !empty($v)){
        $images = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=".$v."&key=AIzaSyC-DQo6s0e_1BWM2d3cSFXrS6oQKoRIdoI&part=snippet"), true);
        $images = $images["items"][0]["snippet"]["thumbnails"];
        if(isset($images["maxres"])){
            $image  = $images["maxres"]['url'];
        }elseif(isset($images["standard"])) {
           $image  = $images["standard"]['url'];
        }else{
            $image =  $this->__folder . '/images/not-img.jpg';
        }
        $arItem["PREVIEW_PICTURE"]["SRC"]  = $image;
    } 
}