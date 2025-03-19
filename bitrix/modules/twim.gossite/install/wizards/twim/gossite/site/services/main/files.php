<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

use Bitrix\Main\Config\Option,
    Bitrix\Main\Loader;

if (!defined("WIZARD_SITE_ID"))
	return;

if (!defined("WIZARD_SITE_DIR"))
	return;
 
if (WIZARD_INSTALL_DEMO_DATA)
{
	$path = str_replace("//", "/", WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/"); 
	$handle = @opendir($path);
	if ($handle)
	{
		while ($file = readdir($handle))
		{
			if (in_array($file, array(".", "..")))
				continue; 
			
			CopyDirFiles(
				$path.$file,
				WIZARD_SITE_PATH."/".$file,
				$rewrite = true, 
				$recursive = true,
				$delete_after_copy = false
			);
		}
		CModule::IncludeModule("search");
		CSearch::ReIndexAll(Array(WIZARD_SITE_ID, WIZARD_SITE_DIR));
	}
    
	$arUrlRewrite = array(); 
	if (file_exists(WIZARD_SITE_ROOT_PATH."/urlrewrite.php"))
	{
		include(WIZARD_SITE_ROOT_PATH."/urlrewrite.php");
	}

    $arNewUrlRewrite = array(
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."administration/municipal-bidding-and-procurement/#",
            "RULE" => "",
            "ID" => "bitrix:news",
            "PATH" => WIZARD_SITE_DIR."administration/municipal-bidding-and-procurement/index.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."administration/official-statements-and-reports/#",
            "RULE" => "",
            "ID" => "bitrix:news",
            "PATH" => WIZARD_SITE_DIR."administration/official-statements-and-reports/index.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."anti-corruption/normative-legal/#",
            "RULE" => "",
            "ID" => "bitrix:news",
            "PATH" => WIZARD_SITE_DIR."anti-corruption/normative-legal/index.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."information/prosecutor-informs/#",
            "RULE" => "",
            "ID" => "bitrix:news",
            "PATH" => WIZARD_SITE_DIR."information/prosecutor-informs/index.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."official-documents/documents/#",
            "RULE" => "",
            "ID" => "bitrix:news",
            "PATH" => WIZARD_SITE_DIR."official-documents/documents/index.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."media/photo-gallery/#",
            "RULE" => "",
            "ID" => "bitrix:photo",
            "PATH" => WIZARD_SITE_DIR."media/photo-gallery/index.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."municipal-services/#",
            "RULE" => "",
            "ID" => "bitrix:news",
            "PATH" => WIZARD_SITE_DIR."municipal-services/index.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."information/events/#",
            "RULE" => "",
            "ID" => "bitrix:news",
            "PATH" => WIZARD_SITE_DIR."information/events/index.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."information/reestr_info/#",
            "RULE" => "",
            "ID" => "bitrix:news",
            "PATH" => WIZARD_SITE_DIR."information/reestr_info/index.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."opendata/#",
            "RULE" => "",
            "ID" => "twim:opendata",
            "PATH" => WIZARD_SITE_DIR."opendata/index.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."news/#",
            "RULE" => "",
            "ID" => "bitrix:news",
            "PATH" => WIZARD_SITE_DIR."news/index.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."town-building/dokumentatsiya-po-planirovke-territorii/#",
            "RULE" => "",
            "ID" => "bitrix:news",
            "PATH" => WIZARD_SITE_DIR."town-building/dokumentatsiya-po-planirovke-territorii/index.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."administration/structure/([0-9a-zA-Z_-]+)/.*#",
            "RULE" => "CODE=$1",
            "ID" => "",
            "PATH" => WIZARD_SITE_DIR."administration/structure/detail.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."town-building/news/#",
            "RULE" => "",
            "ID" => "bitrix:news",
            "PATH" => WIZARD_SITE_DIR."town-building/news/index.php",
        ),
        array(
            "CONDITION" => "#^".WIZARD_SITE_DIR."town-building/docs/#",
            "RULE" => "",
            "ID" => "bitrix:news",
            "PATH" => WIZARD_SITE_DIR."town-building/docs/index.php",
        ),
    );         	
	foreach ($arNewUrlRewrite as $arUrl)
	{
		if (!in_array($arUrl, $arUrlRewrite))
		{
			CUrlRewriter::Add($arUrl);
		}
	}
    
}

function ___writeToAreasFile($fn, $text)
{
	if(file_exists($fn) && !is_writable($abs_path) && defined("BX_FILE_PERMISSIONS"))
		@chmod($abs_path, BX_FILE_PERMISSIONS);

	$fd = @fopen($fn, "wb");
	if(!$fd)
		return false;

	if(false === fwrite($fd, $text))
	{
		fclose($fd);
		return false;
	}

	fclose($fd);

	if(defined("BX_FILE_PERMISSIONS"))
		@chmod($fn, BX_FILE_PERMISSIONS);
}

//check include
CheckDirPath(WIZARD_SITE_PATH."include/");
// rewrite other
$wizard =& $this->GetWizard();

$titleSite = $wizard->GetVar("siteSlogan");
___writeToAreasFile(WIZARD_SITE_PATH."include/title-site.php", $titleSite);
Bitrix\Main\SiteTable::update(WIZARD_SITE_ID, array(
    'SITE_NAME' => $titleSite
));

Loader::includeModule("twim.gossite");

if(defined('TWIM_GOSSITE_MODULE_ID')){
    $email = $wizard->GetVar("siteEmail");
    Option::set(TWIM_GOSSITE_MODULE_ID, "email", $email, WIZARD_SITE_ID);
    $emailForm = $wizard->GetVar("siteEmailForm");
    Option::set(TWIM_GOSSITE_MODULE_ID, "email_form", $emailForm, WIZARD_SITE_ID);
    $phone = $wizard->GetVar("sitePhone");
    Option::set(TWIM_GOSSITE_MODULE_ID, "phone", $phone, WIZARD_SITE_ID);
    $address = $wizard->GetVar("siteAddress");
    Option::set(TWIM_GOSSITE_MODULE_ID, "address", $address, WIZARD_SITE_ID);
    $fio_boss = $wizard->GetVar("fio_boss");
    Option::set(TWIM_GOSSITE_MODULE_ID, "fio_boss", $fio_boss, WIZARD_SITE_ID);
    $post_boss = $wizard->GetVar("post_boss");
    Option::set(TWIM_GOSSITE_MODULE_ID, "post_boss", $post_boss, WIZARD_SITE_ID);
    $api_map_key_ya = $wizard->GetVar("api_key_ya_map");
    Option::set(TWIM_GOSSITE_MODULE_ID, "api_map_key_ya", $api_map_key_ya, WIZARD_SITE_ID);

    $siteLogo = $wizard->GetVar("siteLogo");
    if($siteLogo>0)
    {
        $ff = CFile::GetByID($siteLogo);
        if($zr = $ff->Fetch())
        {
            $strOldFile = str_replace("//", "/", WIZARD_SITE_ROOT_PATH."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$zr["SUBDIR"]."/".$zr["FILE_NAME"]);
            CheckDirPath($_SERVER['DOCUMENT_ROOT']."/upload/twim.gossite");
            $pathNewlogo = "/upload/twim.gossite/logo_" . WIZARD_SITE_ID . ".png";
            @copy($strOldFile, $_SERVER['DOCUMENT_ROOT'].$pathNewlogo);
            CFile::Delete($siteLogo);
            Option::set(TWIM_GOSSITE_MODULE_ID, "img_gerb", $pathNewlogo, WIZARD_SITE_ID);
        }
    }
    $photoBoss = $wizard->GetVar("photoBoss");
    if($photoBoss>0)
    {
        $ff = CFile::GetByID($photoBoss);
        if($zr = $ff->Fetch())
        {
            $strOldFile = str_replace("//", "/", WIZARD_SITE_ROOT_PATH."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$zr["SUBDIR"]."/".$zr["FILE_NAME"]);
            CheckDirPath($_SERVER['DOCUMENT_ROOT']."/upload/twim.gossite");
            $pathNewImgBoss = "/upload/twim.gossite/" .$zr["ORIGINAL_NAME"];
            @copy($strOldFile, $_SERVER['DOCUMENT_ROOT'].$pathNewImgBoss);
            CFile::Delete($siteLogo);
            Option::set(TWIM_GOSSITE_MODULE_ID, "img_boss", $pathNewImgBoss, WIZARD_SITE_ID);
        }
    }
}
 
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH, Array("SITE_DIR" => WIZARD_SITE_DIR));


if (WIZARD_INSTALL_DEMO_DATA)
{ 
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.section.php", array("SITE_DESCRIPTION" => htmlspecialcharsbx($wizard->GetVar("siteMetaDescription"))));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.section.php", array("SITE_KEYWORDS" => htmlspecialcharsbx($wizard->GetVar("siteMetaKeywords"))));
}
?>
