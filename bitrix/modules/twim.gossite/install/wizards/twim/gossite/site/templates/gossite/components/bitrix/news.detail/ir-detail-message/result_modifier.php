<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// �������������� ���� ���������
$arResult["DISPLAY_PROPERTIES"]["DATE"]["DISPLAY_VALUE"] = ConvertDateTime($arResult["ITEMS"][$key]["DISPLAY_PROPERTIES"]["DATE"]["DISPLAY_VALUE"], "DD.MM.YYYY");
// ��������� ��������� ������ ������
$idPropsCat = $arResult["DISPLAY_PROPERTIES"]["CATEGORY"]["VALUE"];
$arResult["DISPLAY_PROPERTIES"]["CATEGORY"]["DISPLAY_VALUE"] =  $arResult["DISPLAY_PROPERTIES"]["CATEGORY"]["LINK_SECTION_VALUE"][$idPropsCat]["NAME"];
// ��������� ������ ������
$idPropsEl = $arResult["DISPLAY_PROPERTIES"]["AGENCY"]["VALUE"];
$arResult["DISPLAY_PROPERTIES"]["AGENCY"]["DISPLAY_VALUE"] =  $arResult["DISPLAY_PROPERTIES"]["AGENCY"]["LINK_ELEMENT_VALUE"][$idPropsEl]["NAME"];
// �������������� ���������
if(is_array($arResult["DISPLAY_PROPERTIES"]["COAUTHOR"]["DISPLAY_VALUE"])){
    $listCoauthors = implode(", ", $arResult["DISPLAY_PROPERTIES"]["COAUTHOR"]["DISPLAY_VALUE"]);
} else {
    $listCoauthors = $arResult["DISPLAY_PROPERTIES"]["COAUTHOR"]["DISPLAY_VALUE"];
}
$arResult["DISPLAY_PROPERTIES"]["COAUTHOR"]["DISPLAY_VALUE"]  = strip_tags($listCoauthors);

