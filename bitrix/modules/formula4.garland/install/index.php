<?
	class formula4_garland extends CModule {
		var $MODULE_ID = "formula4.garland";
		var $MODULE_VERSION;
		var $MODULE_VERSION_DATE;
		var $MODULE_NAME;
		var $MODULE_DESCRIPTION;

		function __construct() {
			$arModuleVersion = array();
			include(dirname(__FILE__)."/version.php");
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
			$this->MODULE_NAME = GetMessage("FORMULA_GARLAND_MODULE_NAME");
			$this->MODULE_DESCRIPTION = GetMessage("FORMULA_GARLAND_MODULE_DESC");
			$this->PARTNER_NAME = GetMessage("FORMULA_GARLAND_PARTNER_NAME");
			$this->PARTNER_URI = GetMessage("FORMULA_GARLAND_PARTNER_URI");
		}

		function InstallFiles() {
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/assets/js/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/js/".$this->MODULE_ID, true, true);
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/assets/images/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/images/".$this->MODULE_ID, true, true);
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/assets/css/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/css/".$this->MODULE_ID, true, true);
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/assets/sounds/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/sounds/".$this->MODULE_ID, true, true);
			return true;
		}

		function UnInstallFiles() {
			DeleteDirFilesEx("/bitrix/js/".$this->MODULE_ID."/");
			DeleteDirFilesEx("/bitrix/images/".$this->MODULE_ID."/");
			DeleteDirFilesEx("/bitrix/sounds/".$this->MODULE_ID."/");
			DeleteDirFilesEx("/bitrix/css/".$this->MODULE_ID."/");
			return true;
		}

		function DoInstall() {
			$this->InstallFiles();
			RegisterModule($this->MODULE_ID);
			RegisterModuleDependences("main", "OnEpilog", $this->MODULE_ID);
		}

		function DoUninstall() {
			$this->UnInstallFiles();
			UnRegisterModuleDependences("main", "OnEpilog", $this->MODULE_ID);
			UnRegisterModule($this->MODULE_ID);
		}
	}
?>