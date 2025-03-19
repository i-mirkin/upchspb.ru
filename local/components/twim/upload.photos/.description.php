<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("UP_PHOTO_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("UP_PHOTO_COMPONENT_DESCR"),
	"ICON" => "/images/photo_upload.gif",
	"SORT" => 20,
	"PATH" => array(
		"ID" => "twim",
                "NAME" => GetMessage("T_IBLOCK_DESC_TWIM"),
                "SORT" => 10,
	)
);
?>
