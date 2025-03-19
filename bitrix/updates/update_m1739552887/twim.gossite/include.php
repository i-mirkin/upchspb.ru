<?
use Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

if(!defined('TWIM_GOSSITE_MODULE_ID'))
	define('TWIM_GOSSITE_MODULE_ID', 'twim.gossite');

Loader::registerAutoLoadClasses(TWIM_GOSSITE_MODULE_ID, array(
  'TwimGossite\\Helpers\\GarbageStorage' => 'classes/general/garbageStorage.php',
  'TwimGossite\\Helpers\\CEventGosApplication' => 'classes/general/events.php',
  'TwimGossite\\Helpers\\Agents' => 'classes/general/agents.php',
));

class CTwimGosSite
{
	public static function ShowPanel()
	{

		if ($GLOBALS["USER"]->IsAdmin() && COption::GetOptionString("main", "wizard_solution", "", SITE_ID) == "gossite")
		{
			$GLOBALS["APPLICATION"]->AddPanelButton(array(
				"HREF" => "/bitrix/admin/wizard_install.php?lang=".LANGUAGE_ID."&wizardName=twim:gossite&wizardSiteID=".SITE_ID."&".bitrix_sessid_get(),
				"ID" => "twim_gos_site_wizard",
				"ICON" => "bx-panel-site-wizard-icon",
				"MAIN_SORT" => 2500,
				"TYPE" => "BIG",
				"SORT" => 10,	
				"ALT" => GetMessage("SCOM_BUTTON_DESCRIPTION"),
				"TEXT" => GetMessage("SCOM_BUTTON_NAME"),
				"MENU" => array(),
			));
		}

	}
}
?>
