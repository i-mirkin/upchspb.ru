<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$aMenuLinksExt=$APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
   "IS_SEF" => "N",
   "ID" => $_REQUEST["ID"],
   "IBLOCK_TYPE" => "mun_servise",
   "IBLOCK_ID" => "#MUNSERV_IBLOCK_ID#",
   "SECTION_URL" => "",
   "DEPTH_LEVEL" => "4",
   "CACHE_TYPE" => "A",
   "CACHE_TIME" => "360000"
   ),
   false,
   array('HIDE_ICONS' => 'Y')
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>
