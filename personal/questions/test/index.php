<?
define("NEED_AUTH", true); // выводит CMain::AuthForm выводится system.auth.authorize
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Персональный раздел");


?>
<?

// выбираем всех активных(!) Руководителей, сортируем по уровню и выбираем с самым высоким уровнем (с наименьшим значением)
$rsUser = CUser::GetList(($by = "UF_LEVEL"), ($order = "asc"),
		array(
			"ACTIVE" => "Y",
			"GROUPS_ID" => array(9)
		),
		array(
			"SELECT" => array(
				"ID",
			),
		)
	);
		
if($arUser = $rsUser->Fetch()) {
	echo $arUser['ID'];
}		


/*
$APPLICATION->IncludeComponent(
	"bitrix:fileman.light_editor",
	"",
	Array(
		"CONTENT" => "otvet",
		"HEIGHT" => "300px",
		"ID" => "",
		"INPUT_ID" => "otvet",
		"INPUT_NAME" => "otvet",
		"JS_OBJ_NAME" => "",
		"RESIZABLE" => "Y",
		"USE_FILE_DIALOGS" => "Y",
		"VIDEO_ALLOW_VIDEO" => "Y",
		"VIDEO_BUFFER" => "20",
		"VIDEO_LOGO" => "",
		"VIDEO_MAX_HEIGHT" => "480",
		"VIDEO_MAX_WIDTH" => "640",
		"VIDEO_SKIN" => "/bitrix/components/bitrix/player/mediaplayer/skins/bitrix.swf",
		"VIDEO_WINDOWLESS" => "Y",
		"VIDEO_WMODE" => "transparent",
		"WIDTH" => "100%"
	)
);
*/
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>