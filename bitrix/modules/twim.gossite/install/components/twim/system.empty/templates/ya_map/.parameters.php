<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"COORD_YA_MAP" => Array(
		"NAME" => GetMessage("T_EMPTY_DESC_COORD_YA_MAP"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	),
    "TITLE" => Array(
		"NAME" => GetMessage("T_EMPTY_DESC_TITLE"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("T_EMPTY_DESC_TITLE_DESC"),
	),
    "REGION_NAME" => Array(
		"NAME" => GetMessage("T_EMPTY_FULL_REGION_NAME"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("T_EMPTY_FULL_REGION_NAME_DESC"),
	),
);
?>
