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
$arFilter = Array("TYPE_ID" => "IR_FEEDBACK_FORM", "ACTIVE" => "Y");
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
			"NAME" => GetMessage("IR_IBLOCK"),
		),
        "FILE" => array(
			"SORT" => 110,
			"NAME" => GetMessage("IR_FILE"),
		)
	),
	"PARAMETERS" => array(
        "IBLOCK_TYPE" => array(
            "NAME" => GetMessage("IR_IBLOCK_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlockType,
            "REFRESH" => "Y",
            "PARENT" => "IBLOCK",
        ),
        "IBLOCK_AGANCY_ID" => array(
            "NAME" => GetMessage("IR_IBLOCK_AGANCY_DESC"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlock,
            "PARENT" => "IBLOCK",
        ),
        "IBLOCK_ADD_ID" => array(
            "NAME" => GetMessage("IR_IBLOCK_ADD"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlock,
            "PARENT" => "IBLOCK",
        ),
        "USER_CONSENT" => array(),
		"USE_CAPTCHA" => Array(
			"NAME" => GetMessage("IR_CAPTCHA"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
		"OK_TEXT" => Array(
			"NAME" => GetMessage("IR_OK_MESSAGE"), 
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("IR_OK_TEXT"), 
			"PARENT" => "BASE",
		),
		"EMAIL_TO" => Array(
			"NAME" => GetMessage("IR_EMAIL_TO"), 
			"TYPE" => "STRING",
			"DEFAULT" => htmlspecialcharsbx(COption::GetOptionString("main", "email_from")), 
			"PARENT" => "BASE",
		),
        "PROCESS_PERSONAL_DATA" => Array(
			"NAME" => GetMessage("IR_PROCESS_PERSONAL_DATA"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
		"REQUIRED_FIELDS" => Array(
			"NAME" => GetMessage("IR_REQUIRED_FIELDS"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y", 
			"VALUES" => Array(
                "NONE" => GetMessage("IR_ALL_REQ"), 
                "THEME" => GetMessage("IR_THEME"),
                "NAME" => GetMessage("IR_NAME"), 
                "SURNAME" => GetMessage("IR_SURNAME"), 
                "SECOND_NAME" => GetMessage("IR_SECOND_NAME"), 
                "EMAIL" => GetMessage("IR_EMAIL"), 
                "PHONE" => GetMessage("IR_PHONE"),
                "COMPANY" => GetMessage("IR_COMPANY"),
                "MESSAGE" => GetMessage("IR_MESSAGE")
                ),
			"DEFAULT"=>array("THEME", "NAME", "SURNAME", "SECOND_NAME", "EMAIL", "MESSAGE"), 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),
        "COLLECTIVE_APPEAL" => Array(
			"NAME" => GetMessage("IR_COLLECTIVE_APPEAL_DESC"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "IBLOCK",
		),
        "USER_REGISTER" => Array(
			"NAME" => GetMessage("IR_USER_REGISTER_DESC"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
        "INCLUDE_FILE" => Array(
			"NAME" => GetMessage("IR_INCLUDE_FILE"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "FILE",
            "REFRESH"=> "Y",
		),
		"EVENT_MESSAGE_ID" => Array(
			"NAME" => GetMessage("IR_EMAIL_TEMPLATES"), 
			"TYPE"=>"LIST", 
			"VALUES" => $arEvent,
			"DEFAULT"=>"", 
			"MULTIPLE"=>"Y", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),
        "CACHE_TIME"  =>  Array("DEFAULT"=>360000),

	)
);
if ($arCurrentValues["COLLECTIVE_APPEAL"] == "Y")
{
    $arComponentParameters["PARAMETERS"]["IBLOCK_ID_COAUTHORS"] = array(
        "NAME" => GetMessage("IR_IBLOCK_COAUTHORS"),
        "TYPE" => "LIST",
        "VALUES" => $arIBlock,
        "PARENT" => "IBLOCK",
    );
}

if ($arCurrentValues["INCLUDE_FILE"] == "Y")
{
    $arComponentParameters["PARAMETERS"]["FILE_EXT"] = Array(
        "NAME" => GetMessage("IR_FILE_EXT"), 
        "TYPE" => "STRING",
        "DEFAULT" => "doc, txt, rtf, docx, pdf, odt, zip, 7z, jpg, jpeg, png", 
        "PARENT" => "FILE",
    );
    $arComponentParameters["PARAMETERS"]["FILE_SIZE"] = Array(
        "NAME" => GetMessage("IR_FILE_SIZE"), 
        "TYPE" => "STRING",
        "DEFAULT" => "10485760",
        "PARENT" => "FILE",
    );  
}
?>
