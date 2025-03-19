<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult["ITEMS"] as $key =>  $arItem){ //thumb img
	if(!is_array($arItem["PREVIEW_PICTURE"])){
		$arResult["ITEMS"][$key]["PREVIEW_PICTURE"]["SRC"] = $this->__folder."/images/noimgnews.jpg";
		$arResult["ITEMS"][$key]["PREVIEW_PICTURE"]["TITLE"] = $arItem["NAME"];
		$arResult["ITEMS"][$key]["PREVIEW_PICTURE"]["ALT"] = $arItem["NAME"];
	}
}