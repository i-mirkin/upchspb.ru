<?
use Bitrix\Main,
	Bitrix\Main\Localization\Loc;
use Bitrix\Main\Entity;
use Bitrix\Main\EventManager;
Loc::loadMessages(__FILE__);

class bq_schedule extends CModule{
	var $MODULE_ID = "bq.schedule";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";  

	function __construct(){
		$arModuleVersion = array();
		include(__DIR__."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->PARTNER_NAME = "Bquadro";
		$this->PARTNER_URI = "";
		$this->MODULE_NAME = "Генератор расписания";
		$this->MODULE_DESCRIPTION = "";
		return true;
	}

	function InstallDB($install_wizard = true){
		global $DB, $DBType, $APPLICATION;
		RegisterModule($this->MODULE_ID);
		return true;
	}

	function UnInstallDB($arParams = array()){
		global $DB, $DBType, $APPLICATION;
		UnRegisterModule($this->MODULE_ID);
		return true;
	}

	function InstallAgents(){
		$objDateTime = new \Bitrix\Main\Type\DateTime;
		$objDateTime->add("1 hour");
		\CAgent::AddAgent(
			"\\Bq\\Schedule\\Agents\\Generator::run();", 
			$this->MODULE_ID,  
			"N", 
			86400,
			$objDateTime->format('d.m.Y H:00:00'),       // дата первой проверки на запуск
		    "Y",                                  
		    $objDateTime->format('d.m.Y H:00:00')                // дата первого запуска
		);
	}

	function UnInstallAgents(){
		\CAgent::RemoveAgent(
			"\\Bq\\Schedule\\Agents\\Generator::run();", 
			$this->MODULE_ID
		);
	}
	
	function InstallEvents(){
		return true;
	}

	function UnInstallEvents(){
		return true;
	}

	function InstallFiles(){
		return true;
	}

	function InstallPublic(){
		return true;
	}

	function UnInstallPublic(){
		return true;
	}

	function UnInstallFiles(){
		return true;
	}

	function DoInstall(){
		global $APPLICATION, $step;
		$this->InstallFiles();
		$this->InstallDB(false);
		$this->InstallEvents();
		$this->InstallAgents();
		$this->InstallPublic();
		$APPLICATION->IncludeAdminFile(GetMessage("SCOM_INSTALL_TITLE"), __DIR__."/step.php");
	}

	function DoUninstall(){
		global $APPLICATION, $step;
		$this->UnInstallDB();
		$this->UnInstallFiles();
		$this->UnInstallEvents();
		$this->UnInstallAgents();
		$this->UnInstallPublic();
		$APPLICATION->IncludeAdminFile(GetMessage("SCOM_UNINSTALL_TITLE"), __DIR__."/unstep.php");
	}
}
