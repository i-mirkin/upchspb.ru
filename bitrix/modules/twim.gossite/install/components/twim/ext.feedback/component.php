<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());

if(empty($arParams["FILE_SIZE"]) || !is_numeric($arParams["FILE_SIZE"])){
    $arParams["FILE_SIZE"] = 1024 * 1024; // default 1 mb
}
if(empty($arParams["FILE_EXT"])){
   $arParams["FILE_EXT"] = "doc, txt, rtf, docx, pdf, odt, zip, 7z";
}   
$arTheme = $arParams["THEME"];
$arParams["THEME"] = array_filter($arTheme, function($element) {
    return !empty($element);
});
$arParams["IBLOCK_ID"] = trim($arParams["IBLOCK_ID"]);

$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
if($arParams["EVENT_NAME"] == '')
	$arParams["EVENT_NAME"] = "FEEDBACK_FORM";
$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
if($arParams["EMAIL_TO"] == '')
	$arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
$arParams["OK_TEXT"] = trim($arParams["OK_TEXT"]);
if($arParams["OK_TEXT"] == '')
	$arParams["OK_TEXT"] = GetMessage("MF_OK_MESSAGE");

$arResult["HIDE_INPUT_SEND"] = "address"; //default hide
$arResult["SEND"] = ""; //default checked
$arResult["PROCESS_PERSONAL_DATA"] = "Y"; //default checked

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] <> '' && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"]))
{
	$arResult["ERROR_MESSAGE"] = array();
    $arResult["FILES_ID"] = array();
	if(check_bitrix_sessid())
	{
		if(empty($arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $arParams["REQUIRED_FIELDS"]))
		{
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_name"]) <= 1)
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_NAME");	
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("SECOND_NAME", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_second_name"]) <= 1)
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_SECOND_NAME");		
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("SURNAME", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_surname"]) <= 1)
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_SURNAME");		
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_phone"]) <= 2)
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_PHONE");
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["MESSAGE"]) <= 3)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_MESSAGE");
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"]))){
                if(strlen($_POST["user_email"]) == 0)
                    $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_EMAIL");
                if(strlen($_POST["user_email"]) > 1 && !check_email($_POST["user_email"]))
                    $arResult["ERROR_MESSAGE"][] = GetMessage("MF_EMAIL_NOT_VALID");    
            }
        }
        
        if($_POST["send"]=="address"){
            $arResult["HIDE_INPUT_SEND"] = "";
            $arResult["SEND"] = "address";
            if(strlen($_POST["ADDRESS"]) <= 3)
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_ADDRESS");
        } 
        
        if($arParams["PROCESS_PERSONAL_DATA"] == "Y" && $arParams['USER_CONSENT'] != 'Y')
		{
            if($_POST["agreement"] == "y"){
                $arResult["PROCESS_PERSONAL_DATA"] = "Y";
            } else{
                $arResult["PROCESS_PERSONAL_DATA"] = "N";
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_AGREEMENT");
            }
        }
		if($arParams["USE_CAPTCHA"] == "Y")
		{
			include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
			$captcha_code = $_POST["captcha_sid"];
			$captcha_word = $_POST["captcha_word"];
			$cpt = new CCaptcha();
			$captchaPass = COption::GetOptionString("main", "captcha_password", "");
			if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0)
			{
				if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass))
					$arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTCHA_WRONG");
			}
			else
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTHCA_EMPTY");

		}
        
        if($arParams["INCLUDE_FILE"] == "Y" && $_FILES['file_message']['error'] == 0)
		{
            $FileErrorFlag  = false;
            if($_FILES['file_message']['size'] > $arParams["FILE_SIZE"]){
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_FILE_SIZE");
                $FileErrorFlag = true;
            } 
            $file_ext = pathinfo($_FILES['file_message']['name'], PATHINFO_EXTENSION);
            $arFileExtStr = explode(", ", $arParams["FILE_EXT"]);
            function trim_str_feedback($str){ return trim($str);}
            $arFileExt = array_map(trim_str_feedback, $arFileExtStr);
            if(!in_array($file_ext, $arFileExt)){
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_FILE_TYPE");
                $FileErrorFlag = true;
            }
            if(!$FileErrorFlag && empty($arResult["ERROR_MESSAGE"])){
                $arFile = $_FILES['file_message'];
                $arFile["MODULE_ID"] = "iblock";
                $arResult["FILES_ID"][] = CFile::SaveFile($arFile, "iblock");
            }
        }
        	
		if(empty($arResult["ERROR_MESSAGE"]))
		{
			$arFields = Array(
				"AUTHOR" => $_POST["user_surname"] . " " . $_POST["user_name"] . " " . $_POST["user_second_name"],
				"AUTHOR_EMAIL" => $_POST["user_email"],
				"EMAIL_TO" => $arParams["EMAIL_TO"],
				"TEXT" => $_POST["MESSAGE"],
                "PHONE" => $_POST["user_phone"],
                "ADDRESS" => $_POST["ADDRESS"],
                "EMAIL_TO" => $arParams["EMAIL_TO"],
                "THEME" => $arParams["THEME"][$_POST["theme"]],
                "DATE" => ConvertTimeStamp(time(), "FULL", SITE_ID)
			);
            
			if(!empty($arParams["EVENT_MESSAGE_ID"]))
			{
				foreach($arParams["EVENT_MESSAGE_ID"] as $v)
					if(IntVal($v) > 0)
						CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", IntVal($v), $arResult["FILES_ID"]);
			}
			else
				CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields);
            
            if($arParams["ADD_IBLOCK_MESSAGE"] == "Y"){
                Loader::includeModule("iblock");
                if(is_numeric($arParams["IBLOCK_ID"])){
                    $PROP = array();
                    if(!empty($arParams["LIST_PROPERTY_CODE"])){ 
                        $PROP[$arParams["LIST_PROPERTY_CODE"]] = $arResult["FILES_ID"][0]; 
                    }       
                    $message =  GetMessage("MF_IBLOCK_MESSAGE", array(
                        '#THEME#'=> $arParams["THEME"][$_POST["theme"]], 
                        '#AUTHOR#'=> $_POST["user_surname"] . " " . $_POST["user_name"] . " " . $_POST["user_second_name"],
                        '#ADDRESS#'=> $_POST["ADDRESS"],
                        '#PHONE#'=> $_POST["user_phone"],
                        '#AUTHOR_EMAIL#' => $_POST["user_email"],
                        '#TEXT#' => $_POST["MESSAGE"]
                        )
                    );
                    $arLoadProductArray = Array(
                        "MODIFIED_BY" => $USER->GetID(),
                        "IBLOCK_SECTION_ID" => false,
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "PROPERTY_VALUES"=> $PROP,
                        "NAME"           => getMessage("MF_TITLE_IBLOCK_ELEMENT") . $_POST["user_surname"] . " " . $_POST["user_name"] . " " . $_POST["user_second_name"],
                        "ACTIVE"         => "Y", 
                        "PREVIEW_TEXT"   => $message,
                        "PREVIEW_TEXT_TYPE" => "html",
                        "DATE_ACTIVE_FROM" => ConvertTimeStamp(time(), "FULL", SITE_ID)
                    );
                    $el = new CIBlockElement;
                    $el->Add($arLoadProductArray);
                }
  
            }
            
			$_SESSION["MF_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
            $_SESSION["MF_SURNAME"] = htmlspecialcharsbx($_POST["user_surname"]);
            $_SESSION["MF_SECOND_NAME"] = htmlspecialcharsbx($_POST["user_second_name"]);
			$_SESSION["MF_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
	     	LocalRedirect($APPLICATION->GetCurPageParam("success=".$arResult["PARAMS_HASH"], Array("success")));
		}
		
		$arResult["MESSAGE"] = htmlspecialcharsbx($_POST["MESSAGE"]);
        $arResult["ADDRESS"] = htmlspecialcharsbx($_POST["ADDRESS"]);
        $arResult["AUTHOR_PHONE"] = htmlspecialcharsbx($_POST["user_phone"]);
		$arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
        $arResult["AUTHOR_SURNAME"] = htmlspecialcharsbx($_POST["user_surname"]);
        $arResult["AUTHOR_SECOND_NAME"] = htmlspecialcharsbx($_POST["user_second_name"]);
		$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
        $arResult["THEME"] = htmlspecialcharsbx($_POST["theme"]);
	}
	else
		$arResult["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
}
elseif($_REQUEST["success"] == $arResult["PARAMS_HASH"])
{
	$arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];
}

if(empty($arResult["ERROR_MESSAGE"]))
{
	if($USER->IsAuthorized())
	{
		$arResult["AUTHOR_NAME"] = $USER->GetFirstName();
        $arResult["AUTHOR_SURNAME"] = $USER->GetLastName();
        $arResult["AUTHOR_SECOND_NAME"] = $USER->GetParam("SECOND_NAME");
		$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
	}
	else
	{
		if(strlen($_SESSION["MF_NAME"]) > 0)
			$arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
        if(strlen($_SESSION["MF_SURNAME"]) > 0)
			$arResult["AUTHOR_SURNAME"] = htmlspecialcharsbx($_SESSION["MF_SURNAME"]);
        if(strlen($_SESSION["MF_SECOND_NAME"]) > 0)
			$arResult["AUTHOR_SECOND_NAME"] = htmlspecialcharsbx($_SESSION["MF_SECOND_NAME"]);
		if(strlen($_SESSION["MF_EMAIL"]) > 0)
			$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
	}
}

if($arParams["USE_CAPTCHA"] == "Y")
	$arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

$this->IncludeComponentTemplate();
