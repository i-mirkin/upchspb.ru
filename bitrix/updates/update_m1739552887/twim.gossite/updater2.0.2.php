<?
global $DB;
$MODULE_ID = "twim.gossite";

global $MESS;

include(GetLangFileName(dirname(__FILE__)."/lang/", "/updater.php"));

//delete old master
DeleteDirFilesEx("/bitrix/wizards/twim/gossite");
DeleteDirFilesEx("/bitrix/modules/".$MODULE_ID."/install/wizards/twim/gos_site");

//copy files
CheckDirPath($_SERVER["DOCUMENT_ROOT"]."/local/components/twim");
$updater->CopyFiles("install/components/twim", "/local/components/twim");
$updater->CopyFiles("install/js", "js");
$updater->CopyFiles("install/css", "css");
$updater->CopyFiles("install/js", "js");
CheckDirPath($_SERVER["DOCUMENT_ROOT"]."/upload/" . $MODULE_ID);
$updater->CopyFiles("install/images", "/upload");
$updater->CopyFiles("install/local", "/local");


function UpTtwimGosGetModuleObject($moduleID)
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

function UpTtwimGosLoadAndInstallModule($selectedModule)
{
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/classes/general/update_client_partner.php');
    \CUpdateClientPartner::LoadModuleNoDemand($selectedModule, $strError, $bStable = "Y", LANGUAGE_ID);
    if (!IsModuleInstalled($selectedModule))
    {
        $module = UpTtwimGosGetModuleObject($selectedModule);
        if (is_object($module))
        {
            $module->InstallDB();
            $module->InstallEvents();
            $module->InstallFiles();
        }
    }
}

if($updater->CanUpdateDatabase())
{

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

    UpTtwimGosLoadAndInstallModule("twim.recaptchafree");
   
}
?>