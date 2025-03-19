<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class BquadroAddMain extends CBitrixComponent
{
	public function executeComponent()
	{		
		$propCode = $this->arParams['prop_code'];
		if(!$propCode) return;

		global $USER;
		
		CModule::IncludeModule("iblock");
		$propCodeArr = explode(',', $propCode);				
		$arFilter['=PROPERTY_ADD_BOX_MAIN'] = $propCodeArr;
		if(!$USER->IsAdmin()) $arFilter['!PROPERTY_ADMIN_ONLY_VALUE'] = 'Y';
		$arSelect = ['NAME', 'PREVIEW_TEXT', 'DETAIL_PAGE_URL', 'LIST_PAGE_URL', 'PREVIEW_PICTURE', 'IBLOCK_NAME', 'TAG_LINK', 'IBLOCK_ID', 'DATE_ACTIVE_FROM', 'PROPERTY_ADMIN_ONLY'];
		$res	=	\CIBlockElement::GetList(Array("PROPERTY_ADD_BOX_MAIN_SORT"	=>	"ASC"),	$arFilter,	false,	false,	$arSelect);
		$tags = [];
		while	($ob	=	$res->GetNextElement())	{
				$arFields	=	$ob->GetFields();					
				$arProperties = $ob->GetProperties();	
				//$arFields['PROPERTIES'] = $arProperties;						
				if($arProperties['TAG_LINK']['VALUE']) $arFields['tags'] = $arProperties['TAG_LINK']['VALUE'];			 				
				$arResult['ITEMS'][] = $arFields;				
				if(!empty($arProperties['TAG_LINK']['VALUE']) && is_array($arProperties['TAG_LINK']['VALUE'])) {
					foreach($arProperties['TAG_LINK']['VALUE'] as $tagEl) {
						$tags[$tagEl] = $tagEl;
					}
				}				
		}
		$tagList	=	\CIBlockElement::GetList(Array("SORT"	=>	"ASC"),	['IBLOCK_ID' => 31, 'ID' => $tags],	false,	false,	['ID', 'NAME', 'CODE']); 
		while	($tagOb	=	$tagList->GetNextElement())	{
			$tagFields = $tagOb->GetFields();
			$tags[$tagFields['ID']] = $tagFields;
		}		
		$arResult['TAGS'] = $tags;
		
		$boxTitle = $this->arParams['box_title'];
		$arResult['BOX_TITLE'] = htmlspecialcharsbx($boxTitle);
		
		$arResult['SITE_ID'] = SITE_ID;
		
		$this->arResult = $arResult;		
	
		$this->includeComponentTemplate($componentPage);
	}
}