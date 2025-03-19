<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!CModule::IncludeModule("iblock"))
	return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock=array();
$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
{
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}
$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr=$rsProp->Fetch())
{
	$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	if (in_array($arr["PROPERTY_TYPE"], array("F")))
	{
		$arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
$arFilter = Array("TYPE_ID" => "EXT_FEEDBACK_FORM", "ACTIVE" => "Y");
if($site !== false)
	$arFilter["LID"] = $site;

$arEvent = Array();
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext())
	$arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];

$arComponentParameters = array(
    "GROUPS" => array(
        "IBLOCK" =>array(
			"SORT" => 120,
			"NAME" => GetMessage("MFP_IBLOCK"),
		),
        "FILE" => array(
			"SORT" => 110,
			"NAME" => GetMessage("MFP_FILE"),
		)
	),
	"PARAMETERS" => array(
        "USER_CONSENT" => array(),
		"USE_CAPTCHA" => Array(
			"NAME" => GetMessage("MFP_CAPTCHA"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
		"OK_TEXT" => Array(
			"NAME" => GetMessage("MFP_OK_MESSAGE"), 
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("MFP_OK_TEXT"), 
			"PARENT" => "BASE",
		),
		"EMAIL_TO" => Array(
			"NAME" => GetMessage("MFP_EMAIL_TO"), 
			"TYPE" => "STRING",
			"DEFAULT" => htmlspecialcharsbx(COption::GetOptionString("main", "email_from")), 
			"PARENT" => "BASE",
		),
        "PROCESS_PERSONAL_DATA" => Array(
			"NAME" => GetMessage("MFP_PROCESS_PERSONAL_DATA"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
        "ADD_IBLOCK_MESSAGE" => Array(
			"NAME" => GetMessage("MFP_ADD_IBLOCK_MESSAGE"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "IBLOCK",
            "REFRESH"=> "Y",
		),
        "INCLUDE_FILE" => Array(
			"NAME" => GetMessage("MFP_INCLUDE_FILE"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "FILE",
            "REFRESH"=> "Y",
		),
        "THEME" => Array(
			"NAME" => GetMessage("MFP_THEME"), 
			"TYPE" => "STRING",
            "MULTIPLE"=> "Y", 
			"DEFAULT" => "", 
			"PARENT" => "BASE",
		),
		"REQUIRED_FIELDS" => Array(
			"NAME" => GetMessage("MFP_REQUIRED_FIELDS"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y", 
			"VALUES" => Array("NONE" => GetMessage("MFP_ALL_REQ"), "NAME" => GetMessage("MFP_NAME"), "EMAIL" => GetMessage("MFP_EMAIL"), "SURNAME" => GetMessage("MFP_SURNAME"), "SECOND_NAME" => GetMessage("MFP_SECOND_NAME"), "MESSAGE" => GetMessage("MFP_MESSAGE"), "PHONE" => GetMessage("MFP_PHONE")),
			"DEFAULT"=>"", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),

		"EVENT_MESSAGE_ID" => Array(
			"NAME" => GetMessage("MFP_EMAIL_TEMPLATES"), 
			"TYPE"=>"LIST", 
			"VALUES" => $arEvent,
			"DEFAULT"=>"", 
			"MULTIPLE"=>"Y", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),

	)
);
if ($arCurrentValues["ADD_IBLOCK_MESSAGE"] == "Y")
{
    $arComponentParameters["PARAMETERS"]["IBLOCK_TYPE"] = array(
        "NAME" => GetMessage("MFP_IBLOCK_TYPE"),
        "TYPE" => "LIST",
        "VALUES" => $arIBlockType,
        "REFRESH" => "Y",
        "PARENT" => "IBLOCK",
    );
    $arComponentParameters["PARAMETERS"]["IBLOCK_ID"] = array(
        "NAME" => GetMessage("MFP_IBLOCK"),
        "TYPE" => "LIST",
        "VALUES" => $arIBlock,
        "ADDITIONAL_VALUES" => "Y",
        "PARENT" => "IBLOCK",
    );
    $arComponentParameters["PARAMETERS"]["LIST_PROPERTY_CODE"] = array(
        "NAME" => GetMessage("MFP_IBLOCK_PROPERTY"),
        "TYPE" => "LIST",
        "VALUES" => $arProperty_LNS,
        "ADDITIONAL_VALUES" => "Y",
        "PARENT" => "IBLOCK",
    );
}

if ($arCurrentValues["INCLUDE_FILE"] == "Y")
{
    $arComponentParameters["PARAMETERS"]["FILE_EXT"] = Array(
        "NAME" => GetMessage("MFP_FILE_EXT"), 
        "TYPE" => "STRING",
        "DEFAULT" => "doc, txt, rtf, docx, pdf, odt, zip, 7z", 
        "PARENT" => "FILE",
    );
    $arComponentParameters["PARAMETERS"]["FILE_SIZE"] = Array(
        "NAME" => GetMessage("MFP_FILE_SIZE"), 
        "TYPE" => "STRING",
        "DEFAULT" => "1048576",
        "PARENT" => "FILE",
    );  
}
?>
