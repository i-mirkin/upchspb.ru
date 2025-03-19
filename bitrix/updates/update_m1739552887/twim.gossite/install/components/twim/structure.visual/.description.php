<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("INTR_ISV_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("INTR_ISV_COMPONENT_DESCR"),
	"ICON" => "/images/comp.gif",
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "twim",
                "NAME" => GetMessage("T_IBLOCK_DESC_TWIM"),
                "SORT" => 10,
	),
);
?>
