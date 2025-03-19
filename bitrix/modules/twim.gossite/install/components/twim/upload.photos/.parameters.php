<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

if(!CModule::IncludeModule("iblock"))
	return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));

$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];

	
$arComponentParameters = array(
   "GROUPS" => array(
       "FILES" => array(
			"SORT" => 110,
			"NAME" => GetMessage("UP_PHOTO_FILES"),
		)
   ),
   "PARAMETERS" => array(
	  "IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("UP_PHOTO_DESC_LIST_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("UP_PHOTO_DESC_LIST_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
        "FILE_EXT" => Array(
            "NAME" => GetMessage("UP_PHOTO_FILE_EXT"), 
            "TYPE" => "STRING",
            "DEFAULT" => "jpg, png, jpeg, bmp", 
            "PARENT" => "FILES",
        ),
        "FILE_SIZE" => Array(
            "NAME" => GetMessage("UP_PHOTO_FILE_SIZE"), 
            "TYPE" => "STRING",
            "DEFAULT" => "20971520",
            "PARENT" => "FILES",
        ), 
        "FILE_COUNT_MAX" => Array(
            "NAME" => GetMessage("UP_PHOTO_FILE_COUNT_MAX"), 
            "TYPE" => "STRING",
            "DEFAULT" => "20",
            "PARENT" => "FILES",
        ), 
        "USE_JQUERY" => Array(
            "NAME" => GetMessage("UP_PHOTO_USE_JQUERY"), 
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ), 
        "CACHE_TIME"  =>  array("DEFAULT"=>36000000),
   )
);

?>
