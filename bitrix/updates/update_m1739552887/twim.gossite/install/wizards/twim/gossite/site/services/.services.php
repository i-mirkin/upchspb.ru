<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arServices = Array(
	"main" => Array(
		"NAME" => GetMessage("SERVICE_MAIN_SETTINGS"),
		"STAGES" => Array(
			"files.php", // Copy bitrix files
			"template.php", // Install template
            "settings.php", // Install settings
            "menu.php", // Install menu
            "cevent.php", // Install cevent
		),
	),
	"iblock" => Array(
		"NAME" => GetMessage("SERVICE_IBLOCK_DEMO_DATA"),
		"STAGES" => Array(
			"types.php", //IBlock types
			"news.php",
            "photos.php",
            "video.php",
            "npa.php",
            "structure.php",
            "staff.php",
            "ofrep.php",
            "muntorg.php",
            "munserv.php",
            "jobs.php",
            "anticornpa.php",
            "procinfo.php",
            "honor.php",
            "events.php",
            "opendata.php",
            "slider.php",
            "banners.php",
            "vopros.php",
            "town_building_plan.php",
            "town_building_news.php",
            "town_building_docs.php",
            "internet_reception_list.php",
            "agency_treatments.php",
            "coauthors.php",
            "public_answers.php",
            "reestr_info.php"
		),
	),
);
?>

