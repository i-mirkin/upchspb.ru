<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
Loader::includeModule("iblock");
$arSectionID = array();
foreach($arResult["SECTIONS"] as &$arSection):
    $arSectionID[] = $arSection["ID"];
    foreach($arSection["ITEMS"] as &$arItem):
        $file = CFile::ResizeImageGet($arItem['PICTURE']["ID"], array('width'=>410, 'height'=>230), BX_RESIZE_IMAGE_EXACT, true);                
        if(isset($file['src'])){
            $arItem['PICTURE']["SRC_RE"] = $file['src'];
        }
    endforeach;
endforeach;
$arSelect = Array("ID", "NAME");
$arFilter = Array("IBLOCK_ID"=>$arResult["IBLOCK_ID"], "ID"=>$arSectionID, "CNT_ACTIVE" => "Y");
$res = CIBlockSection::GetList(Array(), $arFilter, true, $arSelect, false);
while($ar_fields = $res->GetNext())
{
 $arResult["SECTION_COUNT_EL"][$ar_fields["ID"]] = $ar_fields["ELEMENT_CNT"];
}
