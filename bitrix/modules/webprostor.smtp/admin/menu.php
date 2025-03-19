<?
IncludeModuleLangFile(__FILE__);
$module_id = "webprostor.smtp";

$moduleAccessLevel = $APPLICATION->GetGroupRight($module_id);

if($moduleAccessLevel > "D")
{
	if(!CModule::IncludeModule($module_id))
		return false;
	
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/panel/webprostor.smtp/menu.css');
	
	$aMenuItems[] = array(
		"module_id" => $module_id,
		"icon" => "sender_menu_icon",
		"text" => GetMessage("WEBPROSTOR_SMTP_INNER_MENU_SEND_TEXT"),
		"url" => "webprostor.smtp_send.php?lang=".LANGUAGE_ID,
	);
	$aMenuItems[] = array(
		"module_id" => $module_id,
		"icon" => "update_marketplace",
		"text" => GetMessage("WEBPROSTOR_SMTP_INNER_MENU_LOGS_TEXT"),
		"url" => "webprostor.smtp_logs.php?lang=".LANGUAGE_ID,
		"more_url" => array("webprostor.smtp_log_view.php"),
	);
	if($moduleAccessLevel > "S")
	{
		$aMenuItems[] = array(
			"module_id" => $module_id,
			"icon" => "fileman_sticker_icon",
			"text" => GetMessage("WEBPROSTOR_SMTP_INNER_MENU_DEBUG_TEXT"),
			"url" => "webprostor.smtp_debug.php?lang=".LANGUAGE_ID,
		);
	}
	$aMenuItems[] = array(
		"module_id" => $module_id,
		"text" => GetMessage("WEBPROSTOR_THANK_THE_DEVELOPER"),
		"icon" => "blog_menu_icon",
		"url" => "https://marketplace.1c-bitrix.ru/solutions/{$module_id}/#tab-rating-link",
	);
	$aMenuItems[] = array(
		"module_id" => $module_id,
		"text" => GetMessage("WEBPROSTOR_INSTRUCTION"),
		"icon" => "learning_menu_icon",
		"url" => "https://webprostor.ru/learning/course/course6/index",
	);
	
	$aMenu = array(
		"parent_menu" => "global_menu_webprostor",
		"section" => $module_id,
		"sort" => 700,
		"text" => GetMessage("WEBPROSTOR_SMTP_MAIN_MENU_TEXT"),
		"icon" => "webprostor_smtp",
		"page_icon" => "",
		"items_id" => "webprostor_smtp",
		"more_url" => array(),
		"items" => $aMenuItems
	);

	return $aMenu;
}

return false;
?> 
