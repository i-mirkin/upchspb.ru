<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
//echo "WIZARD_SITE_ID=".WIZARD_SITE_ID." | ";
//echo "WIZARD_SITE_PATH=".WIZARD_SITE_PATH." | ";
//echo "WIZARD_RELATIVE_PATH=".WIZARD_RELATIVE_PATH." | ";
//echo "WIZARD_ABSOLUTE_PATH=".WIZARD_ABSOLUTE_PATH." | ";
//echo "WIZARD_TEMPLATE_ID=".WIZARD_TEMPLATE_ID." | ";
//echo "WIZARD_TEMPLATE_RELATIVE_PATH=".WIZARD_TEMPLATE_RELATIVE_PATH." | ";
//echo "WIZARD_TEMPLATE_ABSOLUTE_PATH=".WIZARD_TEMPLATE_ABSOLUTE_PATH." | ";
//echo "WIZARD_THEME_ID=".WIZARD_THEME_ID." | ";
//echo "WIZARD_THEME_RELATIVE_PATH=".WIZARD_THEME_RELATIVE_PATH." | ";
//echo "WIZARD_THEME_ABSOLUTE_PATH=".WIZARD_THEME_ABSOLUTE_PATH." | ";
//echo "WIZARD_SERVICE_RELATIVE_PATH=".WIZARD_SERVICE_RELATIVE_PATH." | ";
//echo "WIZARD_SERVICE_ABSOLUTE_PATH=".WIZARD_SERVICE_ABSOLUTE_PATH." | ";
//echo "WIZARD_IS_RERUN=".WIZARD_IS_RERUN." | ";

if (!defined("WIZARD_TEMPLATE_ID"))
	return;

$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"]."/local/templates/".WIZARD_TEMPLATE_ID."_".WIZARD_SITE_ID;

CopyDirFiles(
	$_SERVER["DOCUMENT_ROOT"].WizardServices::GetTemplatesPath(WIZARD_RELATIVE_PATH."/site")."/".WIZARD_TEMPLATE_ID,
	$bitrixTemplateDir,
	$rewrite = true,
	$recursive = true, 
	$delete_after_copy = false,
	$exclude = ""
);

// set js in lang_charset
if(strtolower(LANG_CHARSET) === "windows-1251"){
	unlink($bitrixTemplateDir . "/build/script.min.utf8.js");
	unlink($bitrixTemplateDir . "/build/init.min.utf8.js");
    unlink($bitrixTemplateDir . "/build/control.min.utf8.js");
} else{
	unlink($bitrixTemplateDir . "/build/script.min.js");
	unlink($bitrixTemplateDir . "/build/init.min.js");
    unlink($bitrixTemplateDir . "/build/control.min.js");
	rename($bitrixTemplateDir . "/build/script.min.utf8.js", $bitrixTemplateDir . "/build/script.min.js");
	rename($bitrixTemplateDir . "/build/init.min.utf8.js", $bitrixTemplateDir . "/build/init.min.js");
    rename($bitrixTemplateDir . "/build/control.min.utf8.js", $bitrixTemplateDir . "/build/control.min.js");
}

//CWizardUtil::ReplaceMacros($bitrixTemplateDir."/header.php", array("SITE_DIR" => WIZARD_SITE_DIR));
//CWizardUtil::ReplaceMacros($bitrixTemplateDir."/footer.php", array("SITE_DIR" => WIZARD_SITE_DIR));

//Attach template to default site
$obSite = CSite::GetList($by = "def", $order = "desc", Array("LID" => WIZARD_SITE_ID));
if ($arSite = $obSite->Fetch())
{
	$arTemplates = Array();
	$found = false;
	$foundEmpty = false;
	$obTemplate = CSite::GetTemplateList($arSite["LID"]);
    
    
	while($arTemplate = $obTemplate->Fetch())
	{
		if(!$found && strlen(trim($arTemplate["CONDITION"]))<=0)
		{
			$arTemplate["TEMPLATE"] = WIZARD_TEMPLATE_ID."_".WIZARD_SITE_ID;
			$found = true;
		}
		if($arTemplate["TEMPLATE"] == "empty")
		{
			$foundEmpty = true;
			continue;
		}
		$arTemplates[]= $arTemplate;
	}

	if (!$found)
		$arTemplates[]= Array("CONDITION" => "", "SORT" => 150, "TEMPLATE" => WIZARD_TEMPLATE_ID."_".WIZARD_SITE_ID);

	$arFields = Array(
		"TEMPLATE" => $arTemplates,
		"NAME" => $arSite["NAME"],
	);
	$obSite = new CSite();
	$obSite->Update($arSite["LID"], $arFields);
}
COption::SetOptionString("main", "wizard_template_id", WIZARD_TEMPLATE_ID, false, WIZARD_SITE_ID);
?>
