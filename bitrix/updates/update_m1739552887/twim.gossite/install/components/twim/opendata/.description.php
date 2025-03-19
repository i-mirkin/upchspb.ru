<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("IBLOCK_OPEN_DATA_NAME"),
	"DESCRIPTION" => GetMessage("IBLOCK_OPEN_DATA_DESCRIPTION"),
	"ICON" => "/images/open_data.gif",
	"COMPLEX" => "Y",
	"PATH" => array(
		"ID" => "twim",
                "NAME" => GetMessage("T_IBLOCK_DESC_TWIM"),
                "SORT" => 10,
	),
);

?>
