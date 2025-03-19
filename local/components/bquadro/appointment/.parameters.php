<?
CModule::IncludeModule("iblock");

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock=array();
$rsIBlock = CIBlock::GetList(Array("SORT" => "ASC"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
{
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}

$arComponentParameters = array(
   "GROUPS" => array(
      "SETTINGS" => array(
         "NAME" => GetMessage("SETTINGS_PHR")
      ),
      "PARAMS" => array(
         "NAME" => GetMessage("PARAMS_PHR")
      ),
	  "DATA_SOURCE" => array(
         "NAME" => GetMessage("BA_DATA_SOURCE")
      ),
   ),
   "PARAMETERS" => array(
		"IBLOCK_TYPE" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("BA_BLOCK_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y",
		),
		"IBLOCK_ID_DATE" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("BA_BLOCK_ID_DATE"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
			"ADDITIONAL_VALUES" => "Y",
		),
		"IBLOCK_ID_HOURS" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("BA_BLOCK_ID_HOURS"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
			"ADDITIONAL_VALUES" => "Y",
		),
		"IBLOCK_ID_THEME" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("BA_BLOCK_ID_THEME"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
			"ADDITIONAL_VALUES" => "Y",
		),
		"IBLOCK_ID_SCHEDULE" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("BA_BLOCK_ID_SCHEDULE"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
			"ADDITIONAL_VALUES" => "Y",
		),
		"IBLOCK_ID_RECORD" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("BA_BLOCK_ID_RECORD"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
			"ADDITIONAL_VALUES" => "Y",
		),
		"SECTION_URL" => Array(
			"NAME" => GetMessage("BA_SECTION_URL"), 
			"TYPE" => "STRING",
			"DEFAULT" => '/appointment/', 
			"PARENT" => "BASE",
		),
   )
   

);
?>