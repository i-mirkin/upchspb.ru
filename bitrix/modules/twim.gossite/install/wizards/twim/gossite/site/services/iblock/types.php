<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;
$arTypes = Array(
	Array(
		"ID" => "anticorruption",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 100,
		"LANG" => Array(),
	),
    Array(
		"ID" => "documents",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 200,
		"LANG" => Array(),
	),
    Array(
		"ID" => "honorary_citizens",
		"SECTIONS" => "N",
		"IN_RSS" => "N",
		"SORT" => 300,
		"LANG" => Array(),
	),
    Array(
		"ID" => "internet_reception",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 400,
		"LANG" => Array(),
	),
    Array(
		"ID" => "vopros",
		"SECTIONS" => "N",
		"IN_RSS" => "N",
		"SORT" => 500,
		"LANG" => Array(),
	),
    Array(
		"ID" => "media",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 600,
		"LANG" => Array(),
	),
    Array(
		"ID" => "mun_bidding",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 700,
		"LANG" => Array(),
	),
    Array(
		"ID" => "mun_servise",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 800,
		"LANG" => Array(),
	),
    Array(
		"ID" => "news",
		"SECTIONS" => "N",
		"IN_RSS" => "N",
		"SORT" => 900,
		"LANG" => Array(),
	),
    Array(
		"ID" => "opendata",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 1000,
		"LANG" => Array(),
	),
    Array(
		"ID" => "structure",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 1100,
		"LANG" => Array(),
	),
	Array(
		"ID" => "town_building",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 1200,
		"LANG" => Array(),
	),
	
);

$arLanguages = Array();
$rsLanguage = CLanguage::GetList($by, $order, array());
while($arLanguage = $rsLanguage->Fetch())
	$arLanguages[] = $arLanguage["LID"];

$iblockType = new CIBlockType;
foreach($arTypes as $arType)
{
	$dbType = CIBlockType::GetList(Array(),Array("=ID" => $arType["ID"]));
	if($dbType->Fetch())
		continue;

	foreach($arLanguages as $languageID)
	{
		WizardServices::IncludeServiceLang("type.php", $languageID);

		$code = strtoupper($arType["ID"]);
		$arType["LANG"][$languageID]["NAME"] = GetMessage($code."_TYPE_NAME");
		$arType["LANG"][$languageID]["ELEMENT_NAME"] = GetMessage($code."_ELEMENT_NAME");

		if ($arType["SECTIONS"] == "Y")
			$arType["LANG"][$languageID]["SECTION_NAME"] = GetMessage($code."_SECTION_NAME");
	}

	$iblockType->Add($arType);
}
?>
