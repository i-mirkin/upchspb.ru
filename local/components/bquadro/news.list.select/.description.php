<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("BQ_IBLOCK_DESC_LIST_SELECT"),
	"DESCRIPTION" => GetMessage("BQ_IBLOCK_DESC_LIST_SELECT_DESC"),
	"ICON" => "/images/news_list.gif",
	"SORT" => 20,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "Bquadro",
		"CHILD" => array(
			"ID" => "news",
			"NAME" => GetMessage("BQ_IBLOCK_DESC_NEWS"),
			"SORT" => 10,
			"CHILD" => array(
				"ID" => "news_cmpx",
			),
		),
	),
);

?>