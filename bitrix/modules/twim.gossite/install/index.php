<?
use Bitrix\Main\Config\Option;

global $MESS;

$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang)-strlen("/install/index.php"));
include(GetLangFileName($strPath2Lang."/lang/", "/install/index.php"));

Class twim_gossite extends CModule
{
    const MODULE_ID = 'twim.gossite';
    public $MODULE_ID = "twim.gossite";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_CSS;
    public $MODULE_GROUP_RIGHTS = "Y";

	function __construct()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = GetMessage("GOSSITE_INSTALL_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("GOSSITE_INSTALL_DESCRIPTION");
		$this->PARTNER_NAME = GetMessage("SPER_PARTNER");
		$this->PARTNER_URI = GetMessage("PARTNER_URI");
	}

  function InstallDB()
    {
        RegisterModule("twim.gossite");
        RegisterModuleDependences("main", "OnBeforeProlog", self::MODULE_ID, "CTwimGosSite", "ShowPanel");
        RegisterModuleDependences("main", "OnBeforeUserUpdate", self::MODULE_ID, "TwimGossite\\Helpers\\CEventGosApplication", "OnBeforeUserUpdateHandler");
        RegisterModuleDependences("iblock", "OnBeforeIBlockElementUpdate", self::MODULE_ID, "TwimGossite\\Helpers\\CEventGosApplication", "OnBeforeIBlockElementUpdateHandler");
        //$this->UpTwimGosLoadAndInstallModule("twim.recaptchafree");
        $execTime = date("d.m.Y 00:01:00", time() + 86400);
        \CAgent::AddAgent(
            "\TwimGossite\Helpers\Agents::updateEvents();",
            "twim.gossite",
            "N",
            30 * 24 * 60 * 60,
            $execTime,
            "Y",
            $execTime,
            10
        );
        return true;
    }

    function UnInstallDB($arParams = array())
    {
        UnRegisterModuleDependences("main", "OnBeforeProlog", self::MODULE_ID, "CTwimGosSite", "ShowPanel"); 
        UnRegisterModuleDependences("main", "OnBeforeUserUpdate", self::MODULE_ID, "TwimGossite\\Helpers\\CEventGosApplication", "OnBeforeUserUpdateHandler");
        UnRegisterModuleDependences("iblock", "OnBeforeIBlockElementUpdate", self::MODULE_ID, "TwimGossite\\Helpers\\CEventGosApplication", "OnBeforeIBlockElementUpdateHandler");
        UnRegisterModule("twim.gossite");
        $rsAgent = \CAgent::GetList([], [
            'MODULE_ID' => "twim.gossite",
        ]);
        while ($arAgent = $rsAgent->Fetch()) {
            \CAgent::Delete($arAgent['ID']);
        }
        if (!$arParams['savedata']) {
            Option::delete(self::MODULE_ID);
        }
        return true;
    }

    function InstallEvents()
    {
        global $DB;
        include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/" . self::MODULE_ID . "/install/events/set_events.php");
        include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/" . self::MODULE_ID . "/install/user_fields/set_user_fields.php");
        return true;
    }

    function UnInstallEvents($arParams = array())
    {
        global $DB;
        if (!$arParams['savedata']) {
            include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/" . self::MODULE_ID ."/install/events/del_events.php");
            include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/" . self::MODULE_ID . "/install/user_fields/del_user_fields.php");
        }
        return true;
    }

    function InstallFiles()
    {
        CheckDirPath($_SERVER["DOCUMENT_ROOT"]."/local/components/twim");
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/" . self::MODULE_ID ."/install/components/twim", $_SERVER["DOCUMENT_ROOT"]."/local/components/twim", true, true);
        CheckDirPath($_SERVER["DOCUMENT_ROOT"]."/bitrix/js/". self::MODULE_ID);
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/" . self::MODULE_ID ."/install/js", $_SERVER["DOCUMENT_ROOT"]."/bitrix/js", true, true);
        CheckDirPath($_SERVER["DOCUMENT_ROOT"]."/bitrix/css/". self::MODULE_ID);
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/" . self::MODULE_ID ."/install/css", $_SERVER["DOCUMENT_ROOT"]."/bitrix/css", true, true);
        CheckDirPath($_SERVER["DOCUMENT_ROOT"]."/upload/" . self::MODULE_ID);
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/" . self::MODULE_ID ."/install/images", $_SERVER["DOCUMENT_ROOT"]."/upload", true, true);  
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/" . self::MODULE_ID ."/install/local", $_SERVER["DOCUMENT_ROOT"]."/local", true, true);  
        return true;
    }

    function UnInstallFiles($arParams = array())
    {
        DeleteDirFilesEx("/bitrix/js/". self::MODULE_ID);
        DeleteDirFilesEx("/bitrix/css/". self::MODULE_ID);
        return true;
    }

    function DoInstall()
    {
        global $APPLICATION;

        if (!IsModuleInstalled("twim.gossite"))
        {
            $this->InstallDB();
            $this->InstallEvents();
            $this->InstallFiles();
        }
    }

    function DoUninstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION, $step;
        $step = IntVal($step);
		if($step<2)
		{
			$APPLICATION->IncludeAdminFile(GetMessage("GOSSITE_INSTALL_UNINSTALL_TITLE"), $DOCUMENT_ROOT."/bitrix/modules/".self::MODULE_ID."/install/unstep.php");
		}
		elseif($step==2)
		{
            $this->UnInstallDB(array("savedata" => $_REQUEST["savedata"]));
            $this->UnInstallEvents(array("savedata" => $_REQUEST["savedata"]));
            $this->UnInstallFiles(array("savedata" => $_REQUEST["savedata"]));
        }	
    }


    function UpTwimGosGetModuleObject($moduleID)
    {
        if(!class_exists('CModule'))
        {
            global $DB, $DBType, $DBHost, $DBLogin, $DBPassword, $DBName, $DBDebug, $DBDebugToFile, $APPLICATION, $USER;
            require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include.php");
        }

        $installFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$moduleID."/install/index.php";
        if (!file_exists($installFile))
            return false;
        include_once($installFile);

        $moduleIDTmp = str_replace(".", "_", $moduleID);
        if (!class_exists($moduleIDTmp))
            return false;

        return new $moduleIDTmp;
    }

    function UpTwimGosLoadAndInstallModule($selectedModule)
    {
        $strError = "";
        require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/classes/general/update_client_partner.php');
        \CUpdateClientPartner::LoadModuleNoDemand($selectedModule, $strError, $bStable = "Y", LANGUAGE_ID);
        if (!IsModuleInstalled($selectedModule))
        {
            $module =  $this->UpTwimGosGetModuleObject($selectedModule);
            if (is_object($module))
            {
                $module->InstallDB();
                $module->InstallEvents();
                $module->InstallFiles();
            }
        }
    }
}
?>
