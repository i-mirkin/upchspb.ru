<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach($arResult["ITEMS"] as $key => &$arItem){
    if(empty($arItem["DISPLAY_PROPERTIES"]["USER"]["DISPLAY_VALUE"])){
        $arResult["ITEMS"][$key]["DISPLAY_PROPERTIES"]["USER"]["DISPLAY_VALUE"] = getMessage("QU_USER_ANONIM");
    }
    
    if(empty($arItem["DISPLAY_PROPERTIES"]["AUHTOR_ANSWER"]["DISPLAY_VALUE"])){
        $arResult["ITEMS"][$key]["DISPLAY_PROPERTIES"]["AUHTOR_ANSWER"]["DISPLAY_VALUE"] = getMessage("QU_USER_ADMIN");
    }
    $arResult["ITEMS"][$key]["DATE_CREATE"] = FormatDate("j F Y, H:i", MakeTimeStamp($arItem["DATE_CREATE"]));
    $arResult["ITEMS"][$key]["TIMESTAMP_X"] = FormatDate("j F Y, H:i", MakeTimeStamp($arItem["TIMESTAMP_X"]));
	
	if(isset($arItem['DISPLAY_PROPERTIES']['TAG_LINK']['VALUE']) && !empty($arItem['DISPLAY_PROPERTIES']['TAG_LINK']['VALUE'])) {	
		foreach($arItem['DISPLAY_PROPERTIES']['TAG_LINK']['VALUE'] as $tagItemsLink) {
			$tagLinkArr[] = $tagItemsLink;
			$arItem['TAG_LINKS'][$tagItemsLink] = '';
		}
	}
    
}





$tagArr = [];
$obCache = new CPHPCache();
if( $obCache->InitCache('36000','tag_'.$APPLICATION->GetCurPage()) )// Если кэш валиден
{
   $arr = $obCache->GetVars();// Извлечение переменных из кэша
   $tagArr = $arr['tagArr'];
}
elseif( $obCache->StartDataCache()  )// Если кэш невалиден
{
	
	$arFilterTag = Array(
		"IBLOCK_ID"=>31,
		"ACTIVE"=>"Y", 
		"ID"=>$tagLinkArr
	);
	$resTag = CIBlockElement::GetList(Array(), $arFilterTag);
	while($ar_fieldsTag = $resTag->GetNext())
	{		
		$tagArr[$ar_fieldsTag['ID']] = [
			'NAME' => $ar_fieldsTag['NAME'],
			'CODE' => $ar_fieldsTag['CODE'],
		];
	}
	$obCache->EndDataCache(["tagArr" => $tagArr]);   
}


foreach($arResult["ITEMS"] as $key =>  &$arItem){
	if(isset($arItem['TAG_LINKS']) && !empty($arItem['TAG_LINKS'])) {		
		foreach($arItem['TAG_LINKS'] as $k => &$v) {
			if(isset($tagArr[$k])) $v = $tagArr[$k];			
		}
	}
}

