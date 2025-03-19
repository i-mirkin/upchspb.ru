<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $themeConfig;
if(isset($themeConfig['main_page']["news_preview"]) && file_exists(__DIR__ . "/images/" . $themeConfig['main_page']["news_preview"] . ".png")){
	$prev_pic = $this->__folder. "/images/" . $themeConfig['main_page']["news_preview"] . ".png";
} else {
	$prev_pic = $this->__folder."/images/noimgnews.jpg";
}
foreach($arResult["ITEMS"] as $key =>  $arItem){ //thumb img
	if(!is_array($arItem["PREVIEW_PICTURE"])){
		$arResult["ITEMS"][$key]["PREVIEW_PICTURE"]["SRC"] = $prev_pic;
		$arResult["ITEMS"][$key]["PREVIEW_PICTURE"]["TITLE"] = $arItem["NAME"];
		$arResult["ITEMS"][$key]["PREVIEW_PICTURE"]["ALT"] = $arItem["NAME"];
	}
}