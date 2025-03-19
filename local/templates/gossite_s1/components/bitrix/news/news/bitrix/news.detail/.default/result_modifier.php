<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$cp = $this->__component; // ������ ����������

if (is_object($cp))
{
   // ������� � arResult ���������� ��� ���� - MY_TITLE � IS_OBJECT
   $cp->arResult['OGIMG'] = $arResult["PREVIEW_PICTURE"]["SRC"];
   $cp->SetResultCacheKeys(array('OGIMG'));
   // �������� �� � ����� arResult, � ������� �������� ������
   $arResult['OGIMG'] = $cp->arResult['OGIMG'];
}

if(!empty($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTOS"]["VALUE"])){
    //����� ���������� ������ ����� � �������� � ���
    foreach($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTOS"]["VALUE"] as $arItem):
        $file_trumb = CFile::ResizeImageGet($arItem, array('width'=>350, 'height'=>265), BX_RESIZE_IMAGE_EXACT, true);                
        $file_large = CFile::ResizeImageGet($arItem, array('width'=>1300, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, true, false, false, 70);                
        $fvDesc = '';
        if(isset($file_trumb['src'])){            
            foreach($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTOS"]["FILE_VALUE"] as $fv) {
            	if($arItem == $fv["ID"]) $fvDesc = $fv['DESCRIPTION'];
            }
            $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTOS"]["DISPLAY_VALUE_SRC"][] = array("ID"=>$arItem, "TRUMB"=>$file_trumb, "LARGE"=>$file_large, "DESCRIPTION" => $fvDesc);
        }
    endforeach;
}

$footNotes = $arResult['DISPLAY_PROPERTIES']['FOOTNOTES']['VALUE'] ?: '';
if($footNotes) {
	$footNotesList = [];
	$obCache = new CPHPCache();
	if( $obCache->InitCache('36000','tag_'.$arResult['ID']) )// ���� ��� �������
	{
	   $arr = $obCache->GetVars();// ���������� ���������� �� ����
	   $footNotesList = $arr['footNotesList'];
	}
	elseif( $obCache->StartDataCache()  )// ���� ��� ���������
	{
		
		$arFilterNotes = Array(
			"IBLOCK_ID"=>42,
			"ACTIVE"=>"Y", 
			"ID"=>$footNotes
		);
		$resNotes = CIBlockElement::GetList(Array(), $arFilterNotes);
		while($ar_fieldsNotes = $resNotes->GetNext())
		{		
			$footNotesList[$ar_fieldsNotes['ID']] = $ar_fieldsNotes['~PREVIEW_TEXT'];
		}
		$obCache->EndDataCache(["footNotesList" => $footNotesList]);   
	}
}

$arResult['FOOTNOTES'] = $footNotesList;
?>
<!--<div class="atooltip" title="testtext">ATOOLTIP</div>-->