<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
use Bitrix\Main\Loader;
use Bitrix\Main\Context;

global $USER;

if(!isset($arParams["CACHE_TIME"])) {
	$arParams["CACHE_TIME"] = 3600;
}

if($arParams["IBLOCK_AGANCY_ID"] < 1) {
	ShowError(getMessage("IR_ERROR_IBLOCK_AGANCY_ID"));
	return false;
}
if($arParams["IBLOCK_ADD_ID"] < 1) {
	ShowError(getMessage("IR_ERROR_IBLOCK_ADD_ID"));
	return false;
}
if($arParams["IBLOCK_ID_COAUTHORS"] < 1 && $arParams["COLLECTIVE_APPEAL"] == "Y") {
	ShowError(getMessage("IR_ERROR_IBLOCK_ID_COAUTHORS"));
	return false;
}

$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());

if(empty($arParams["FILE_SIZE"]) || !is_numeric($arParams["FILE_SIZE"])){
    $arParams["FILE_SIZE"] = 1024 * 1024; // default 1 mb
}
if(empty($arParams["FILE_EXT"])){
   $arParams["FILE_EXT"] = "doc, txt, rtf, docx, pdf, odt, zip, 7z";
}   
$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
if($arParams["EVENT_NAME"] == ''){
    $arParams["EVENT_NAME"] = "IR_FEEDBACK_FORM";
}
$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
if($arParams["EMAIL_TO"] == ''){
    $arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
}
$arParams["OK_TEXT"] = trim($arParams["OK_TEXT"]);
if($arParams["OK_TEXT"] == ''){
    $arParams["OK_TEXT"] = GetMessage("IR_OK_MESSAGE");
}
$arParams["USER_REGISTER"] = (($arParams["USER_REGISTER"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
$arParams["COLLECTIVE_APPEAL"] = ($arParams["COLLECTIVE_APPEAL"] != "Y" ? "N" : "Y");

if(COption::GetOptionString("main","new_user_registration_email_confirmation") == "Y"){
    $arResult["REG_EMAIL_CONFIRM"] = "Y";
}
$def_group = COption::GetOptionString("main", "new_user_registration_def_group", "");
if($def_group <> "")
	$arResult["GROUP_POLICY"] = CUser::GetGroupPolicy(explode(",", $def_group));
else
	$arResult["GROUP_POLICY"] = CUser::GetGroupPolicy(array());

$arResult["FEILDS"] = [];
$arResult["FEILDS"]["PROCESS_PERSONAL_DATA"] = "Y"; //default checked  

$request = Context::getCurrent()->getRequest();
$arPost = $request->getPostList()->toArray();
$server = Context::getCurrent()->getServer();
$arFiles = $request->getFileList()->toArray();

$arResult["BACK_URL"] = $server->getScriptName();

$cache_id = serialize(array($arParams, ($arParams['CACHE_GROUPS']==='N'? false: $USER->GetGroups()))); 
$obCache = new CPHPCache; 
if ($obCache->InitCache($arParams['CACHE_TIME'], $cache_id, '/ir')) 
{ 
   $vars = $obCache->GetVars(); 
   $arResult = array_merge($arResult, $vars['arResult']); 
} 
elseif ($obCache->StartDataCache()) 
{ 
   if(!Loader::includeModule("iblock")) {
        $this->AbortResultCache();
        ShowError("IBLOCK_MODULE_NOT_INSTALLED");
        return false;
    }
    $rsIBlock = CIBlock::GetList(array(), array(
        "ACTIVE" => "Y",
        "ID" => array($arParams["IBLOCK_AGANCY_ID"], $arParams["IBLOCK_ADD_ID"], $arParams["IBLOCK_ID_COAUTHORS"]),
        "SITE_ID" => SITE_ID,
    ));
    $arIblocksId = [];
    while ($arIBlock = $rsIBlock->GetNext()) {
        $arIblocksId[] = $arIBlock["ID"];  
    }
    if(!in_array($arParams["IBLOCK_AGANCY_ID"], $arIblocksId)) {
        ShowError(getMessage("IR_ERROR_IBLOCK_AGANCY_ID"));
        $this->abortResultCache();
    }
    if(!in_array($arParams["IBLOCK_ADD_ID"], $arIblocksId)) {
        ShowError(getMessage("IR_ERROR_IBLOCK_ADD_ID"));
        $this->abortResultCache();
    }
    if(!in_array($arParams["IBLOCK_ID_COAUTHORS"], $arIblocksId) && $arParams["COLLECTIVE_APPEAL"] == "Y") {
        ShowError(getMessage("IR_ERROR_IBLOCK_ID_COAUTHORS"));
        $this->abortResultCache();
    }
    
    global $CACHE_MANAGER;
    $CACHE_MANAGER->StartTagCache('/ir');
    $arEmails = [];
    //get agency elemetns
    $arAgancy = [];
    $arSort = array("SORT"=>"ASC");
    $arFilter = array("IBLOCK_ID"=>IntVal($arParams["IBLOCK_AGANCY_ID"]), "ACTIVE" => "Y");
    $arSelect = array("ID", "IBLOCK_ID", "NAME", "IBLOCK_SECTION_ID", "PROPERTY_EMAIL");
    $rsElement = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
    $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_AGANCY_ID"]);
    while($obElement = $rsElement->GetNextElement()) {
        $arFields = $obElement->GetFields();  
        $arAgancy[$arFields["ID"]] = $arFields;
        $arProps = $obElement->GetProperties();  
        if(isset($arProps["EMAIL"]) && !empty($arProps["EMAIL"]["VALUE"])){
            $arEmails[$arFields["ID"]] = $arProps["EMAIL"]["VALUE"];
        }
    }

    //get agency sections
    $arAgancyCat = [];
    $arSelectSec = Array("ID", "IBLOCK_ID", "NAME");
    $arFilterSec = Array("IBLOCK_ID"=>IntVal($arParams["IBLOCK_AGANCY_ID"]), "DEPTH_LEVEL" => 1, "ACTIVE"=>"Y");
    $resSec = CIBlockSection::GetList($arSort, $arFilterSec, false, $arSelectSec, false);
    while($arSec = $resSec->Fetch()){
        $arAgancyCat[$arSec["ID"]] = $arSec;
    }
 
    foreach ($arAgancy as $id => $arItem) {
        if(isset($arAgancyCat[$arItem["IBLOCK_SECTION_ID"]])){
            $arAgancyCat[$arItem["IBLOCK_SECTION_ID"]]["ITEMS"][$id] = $arItem;
        }  
    }

    $key = key($arAgancyCat);
    $arAgancyCat[$key]["SELECTED"] = "Y";
    $arResult["FEILDS"]["agancy"] = $arAgancyCat;
    $arResult["FEILDS"]["arEmails"] = $arEmails;
    $CACHE_MANAGER->EndTagCache();
    $obCache->EndDataCache(array( 
       'arResult' => $arResult, 
    )); 
} 

if($server->getRequestMethod() == "POST" && $arPost["submit"] <> '' && (!isset($arPost["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $arPost["PARAMS_HASH"]))
{
	$arResult["ERROR_MESSAGE"] = array();
	if(check_bitrix_sessid())
	{   
        //required
		if(empty($arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $arParams["REQUIRED_FIELDS"]))
		{
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("THEME", $arParams["REQUIRED_FIELDS"])) && strlen($arPost["theme"]) <= 3){
                $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_THEME");	
            }	
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])) && strlen($arPost["user_name"]) <= 2){
                $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_NAME");
            }	
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("SECOND_NAME", $arParams["REQUIRED_FIELDS"])) 
                    && strlen($arPost["user_second_name"]) <= 1 
                    && $arPost["disabled_user_second_name"] !== "y"){
                $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_SECOND_NAME");	
            }
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("SURNAME", $arParams["REQUIRED_FIELDS"])) && strlen($arPost["user_surname"]) <= 2){
                $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_SURNAME");		
            }	
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])) && strlen($arPost["user_phone"]) <= 6){
                $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_PHONE");
            }
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("COMPANY", $arParams["REQUIRED_FIELDS"])) && strlen($arPost["user_company"]) <= 2){
                $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_COMPANY");
            }	
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])) && strlen($arPost["message"]) <= 10){
                $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_MESSAGE");
            }  
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"]))){
                if(strlen($arPost["user_email"]) == 0){
                    $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_EMAIL");
                }  
                if(strlen($arPost["user_email"]) > 1 && !check_email($arPost["user_email"])){
                    $arResult["ERROR_MESSAGE"][] = GetMessage("IR_EMAIL_NOT_VALID"); 
                }      
            }
        }
        
        //agancy
        if(empty($arPost["category_agancy"])){
            $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_AGANCY");	
        }	
        
        //coauthors
        if($arParams["COLLECTIVE_APPEAL"] == "Y"){
            foreach ($arPost["coauthor_name"] as $key => $name) {
                if(strlen($name) <= 2){
                     $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_NAME_COAUTHOR"); 
                }
            }
            foreach ($arPost["coauthor_surname"] as $key => $surname) {
                if(strlen($surname) <= 2){
                     $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_SURNAME_COAUTHOR"); 
                }
            }
            foreach ($arPost["coauthor_email"] as $key => $email) {
                if(strlen($email) == 0){
                    $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_EMAIL_COAUTHOR");
                }  
                if(strlen($email) > 1 && !check_email($email)){
                    $arResult["ERROR_MESSAGE"][] = GetMessage("IR_EMAIL_NOT_VALID_COAUTHOR"); 
                }      
            }
        }
        
        //personal data
        if($arParams["PROCESS_PERSONAL_DATA"] == "Y" && $arParams['USER_CONSENT'] != 'Y'){
            if($arPost["agreement"] == "y"){
                $arResult["FEILDS"]["PROCESS_PERSONAL_DATA"] = "Y";
            } else{
                $arResult["FEILDS"]["PROCESS_PERSONAL_DATA"] = "N";
                $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_AGREEMENT");
            }
        }
        
        //captcha
		if($arParams["USE_CAPTCHA"] == "Y"){
			include_once($server->getDocumentRoot()."/bitrix/modules/main/classes/general/captcha.php");
			$captcha_code = $arPost["captcha_sid"];
			$captcha_word = $arPost["captcha_word"];
			$cpt = new CCaptcha();
			$captchaPass = COption::GetOptionString("main", "captcha_password", "");
			if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0){
				if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass)){
                    $arResult["ERROR_MESSAGE"][] = GetMessage("IR_CAPTCHA_WRONG");
                }	
			}else{
                $arResult["ERROR_MESSAGE"][] = GetMessage("IR_CAPTHCA_EMPTY");
            }
		}
        
        //files
        $arResult["FILES_ID"] = [];
        if($arParams["INCLUDE_FILE"] == "Y"){
            $arFileExtStr = explode(", ", $arParams["FILE_EXT"]);
            $arFileExt = array_map(function ($str){ return trim($str);}, $arFileExtStr);
            $FileErrorFlag  = false;
            foreach ($arFiles['file_message']['size'] as $key => $size) {
                if($size > 0 && $size > $arParams["FILE_SIZE"]){
                    $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_FILE_SIZE");
                    $FileErrorFlag = true;
                } 
            }
            foreach ($arFiles['file_message']['name'] as $key => $file) {
                if(!empty($file)){
                    $file_ext = pathinfo($file, PATHINFO_EXTENSION);
                    if(!in_array($file_ext, $arFileExt)){
                        $arResult["ERROR_MESSAGE"][] = GetMessage("IR_REQ_FILE_TYPE") . " - ." . $file_ext;
                        $FileErrorFlag = true;
                    }
                } 
            }
            if(!$FileErrorFlag && empty($arResult["ERROR_MESSAGE"])){
                foreach($arFiles['file_message']["name"] as $key => $file) {
                    if(!empty($file)){
                        $tmpFile = Array(
                            "name" => $file,
                            "size" => $arFiles["file_message"]["size"][$key],
                            "tmp_name" => $arFiles["file_message"]["tmp_name"][$key],
                            "type" => $arFiles["file_message"]["type"][$key],
                            "old_file" => "",
                            "del" => "y",
                            "MODULE_ID" => "iblock");

                        $fid = CFile::SaveFile($tmpFile, "iblock");
                        $arResult["FILES_ID"][] = $fid;
                      
                    }
                }
            }
        }
        
        // filter feilds
        $activeCategory = "";
        $activeAgancy = "";
        $arResult["FEILDS"]["theme"] = htmlspecialcharsbx($arPost["theme"]);
        $arResult["FEILDS"]["user_name"] = htmlspecialcharsbx($arPost["user_name"]);
        $arResult["FEILDS"]["user_surname"] = htmlspecialcharsbx($arPost["user_surname"]);
        $arResult["FEILDS"]["user_second_name"] = htmlspecialcharsbx($arPost["user_second_name"]);
        $arResult["FEILDS"]["disabled_user_second_name"] = ($arPost["disabled_user_second_name"] == "y") ? "Y": "N";
        $arResult["FEILDS"]["user_company"] = htmlspecialcharsbx($arPost["user_company"]);
        $arResult["FEILDS"]["user_email"] = htmlspecialcharsbx($arPost["user_email"]);
        $arResult["FEILDS"]["user_phone"] = htmlspecialcharsbx($arPost["user_phone"]);
        $arResult["FEILDS"]["message"] = htmlspecialcharsbx($arPost["message"]);
        $arResult["FEILDS"]["registration"] = ($arPost["registration"] == "y") ? "Y": "N";
		$key = key($arResult["FEILDS"]["agancy"]);
        unset($arResult["FEILDS"]["agancy"][$key]["SELECTED"]);
        if(isset($arResult["FEILDS"]["agancy"][intval($arPost["category_agancy"])])){
            $arResult["FEILDS"]["agancy"][intval($arPost["category_agancy"])]["SELECTED"] = "Y";
            $activeCategory = $arResult["FEILDS"]["agancy"][intval($arPost["category_agancy"])]["NAME"]; 
        }
        if(isset($arResult["FEILDS"]["agancy"][intval($arPost["category_agancy"])]["ITEMS"][intval($arPost["agancy"])])){
           $arResult["FEILDS"]["agancy"][intval($arPost["category_agancy"])]["ITEMS"][intval($arPost["agancy"])]["SELECTED"] = "Y";
           $activeAgancy = $arResult["FEILDS"]["agancy"][intval($arPost["category_agancy"])]["ITEMS"][intval($arPost["agancy"])]["NAME"];
        }
        if($arParams["COLLECTIVE_APPEAL"] == "Y"){
            $arResult["FEILDS"]["coauthors"] = [];
            foreach ($arPost["coauthor_name"] as $key => $name) {
                $arResult["FEILDS"]["coauthors"][$key]["coauthor_name"] = htmlspecialcharsbx($name);
                $arResult["FEILDS"]["coauthors"][$key]["coauthor_surname"] = htmlspecialcharsbx($arPost["coauthor_surname"][$key]);
                $arResult["FEILDS"]["coauthors"][$key]["coauthor_second_name"] = htmlspecialcharsbx($arPost["coauthor_second_name"][$key]);
                $arResult["FEILDS"]["coauthors"][$key]["coauthor_email"] = htmlspecialcharsbx($arPost["coauthor_email"][$key]);
            }
        }
        
        if(empty($arResult["ERROR_MESSAGE"])){
            //registration user
            if($arParams["USER_REGISTER"] == "Y" && $arPost["registration"] == "y"){
                COption::SetOptionString("main","captcha_registration","N");
                $login = randString(50);
                $arResUser = $USER->Register(
                    $login, 
                    $arResult["FEILDS"]["user_name"],
                    $arResult["FEILDS"]["user_surname"],
                    $arPost["password"], 
                    $arPost["confirm_password"], 
                    $arResult["FEILDS"]["user_email"]
                );            
                COption::SetOptionString("main","captcha_registration","Y");
                if($arResUser["TYPE"] == "ERROR"){
                    $arResult["ERROR_MESSAGE"][] = $arResUser["MESSAGE"];
                } 
                if($arResUser["TYPE"] == "OK" && $arResUser["ID"] > 0){
                    $arResult["REG_MESSAGE"] = $arResUser["MESSAGE"];
                    $user = new CUser;
                    if($user->Update($arResUser["ID"], array("LOGIN"=>"user".$arResUser["ID"]))){
                        $arFields = Array(
                            "USER_ID" => $arResUser["ID"],
                            "LOGIN" => "user".$arResUser["ID"],
                            "EMAIL" => $arResult["FEILDS"]["user_email"],
                            "NAME" =>  $arResult["FEILDS"]["user_name"],
                            "LAST_NAME" => $arResult["FEILDS"]["user_surname"],
                            "USER_IP" => $server->get('HTTP_ACCEPT'),
                            "USER_HOST" => $server->get('REMOTE_HOST') 

                        );
                        CEvent::Send("IR_NEW_USER", SITE_ID, $arFields);
                    }
                }
            }
        }
 
        //add message
		if(empty($arResult["ERROR_MESSAGE"])){
            Loader::includeModule("iblock");
            
            $idUser = (isset($arResUser["ID"])) ? $arResUser["ID"] : $USER->GetID();
            
            //coauthors add
            $arCoauthorsId = [];
            $arCoauthors = [];
            if($arParams["COLLECTIVE_APPEAL"] == "Y"){
                foreach ($arResult["FEILDS"]["coauthors"] as $key => $coauthors) {
                    $PROP = array(
                        "NAME_COAUTHOR" => $coauthors["coauthor_name"], 
                        "SURNAME_COAUTHOR" => $coauthors["coauthor_surname"], 
                        "SECOND_NAME_COAUTHOR" => $coauthors["coauthor_second_name"], 
                        "E_MAIL_COAUTHOR" => $coauthors["coauthor_email"], 
                    );
                    $arLoadProductArray = Array(
                        "CREATED_BY" => $idUser, 
                        "IBLOCK_SECTION_ID" => false,
                        "IBLOCK_ID" => $arParams["IBLOCK_ID_COAUTHORS"],
                        "PROPERTY_VALUES"=> $PROP,
                        "NAME"           => $coauthors["coauthor_surname"] . " " . $coauthors["coauthor_name"] . " " . $coauthors["coauthor_second_name"], 
                        "ACTIVE"         => "Y", 
                    );
                    $el = new CIBlockElement;
                    $id = $el->Add($arLoadProductArray);
                    if($id > 0){
                        $arCoauthorsId[] = $id;
                        $arCoauthors[] = $coauthors["coauthor_surname"] . " " . $coauthors["coauthor_name"] . " " . $coauthors["coauthor_second_name"] . " (" . $coauthors["coauthor_email"] . ")";
                    }
                }
            }
            
            //get status def
            $statusId = "";
            $statusName = "";
            $propertyStatus = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ADD_ID"], "CODE"=>"STATUS"));
            while($enum_fields = $propertyStatus->GetNext())
            {
                if($enum_fields["DEF"] == "Y" ){
                    $statusId = $enum_fields["ID"];
                    $statusName = $enum_fields["VALUE"];
                }
            }
            
            if(isset($arResult["FEILDS"]["arEmails"][intval($arPost["agancy"])])){
                $mailsToSend = str_replace(" ", "", $arResult["FEILDS"]["arEmails"][intval($arPost["agancy"])]);
            } else {
                $mailsToSend = $arParams["EMAIL_TO"];
            } 

            //send mail
			$arFields = Array(
                "THEME" => $arResult["FEILDS"]["theme"],
                "NAME_AUTHOR" => $arResult["FEILDS"]["user_name"],
                "SURNAME_AUTHOR" => $arResult["FEILDS"]["user_surname"],
                "SECOND_NAME_AUTHOR" => $arResult["FEILDS"]["user_second_name"],
                "E_MAIL_AUTHOR" => $arResult["FEILDS"]["user_email"],
                "COMPANY_AUTHOR" => $arResult["FEILDS"]["user_company"],
                "PHONE_AUTHOR" => $arResult["FEILDS"]["user_phone"],
                "CATEGORY" => $activeCategory,
                "AGENCY" => $activeAgancy,
                "DATE" => ConvertTimeStamp(time(), "FULL", SITE_ID),
				"EMAIL_TO" => $mailsToSend,
				"TEXT" => $arResult["FEILDS"]["message"], 
                "COAUTHOR" => implode(", <br>", $arCoauthors),
                "STATUS" => $statusName 
			);

			if(!empty($arParams["EVENT_MESSAGE_ID"])){
				foreach($arParams["EVENT_MESSAGE_ID"] as $v){
                    if(IntVal($v) > 0){
                        CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", IntVal($v), $arResult["FILES_ID"]);
                    }	
                }	
			} else {
                CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "", $arResult["FILES_ID"]);
            }

            // add in iblock
            $PROP = array(
                "USER_AUTHOR" => $idUser, 
                "THEME" => $arResult["FEILDS"]["theme"],
                "NAME_AUTHOR" => $arResult["FEILDS"]["user_name"],
                "SURNAME_AUTHOR" => $arResult["FEILDS"]["user_surname"],
                "SECOND_NAME_AUTHOR" => $arResult["FEILDS"]["user_second_name"],
                "E_MAIL_AUTHOR" => $arResult["FEILDS"]["user_email"],
                "COMPANY_AUTHOR" => $arResult["FEILDS"]["user_company"],
                "PHONE_AUTHOR" => $arResult["FEILDS"]["user_phone"],
                "CATEGORY" => intval($arPost["category_agancy"]),
                "AGENCY" => intval($arPost["agancy"]),
                "DATE" => ConvertTimeStamp(time(), "FULL", SITE_ID),
                "FILE" => $arResult["FILES_ID"],
                "COAUTHOR" => $arCoauthorsId,
                "STATUS" => $statusId,
                "MESSAGE" => array("VALUE" => Array("TEXT" => $arResult["FEILDS"]["message"], "TYPE" => "text"))
                
            );
            
            $arLoadProductArray = Array(
                "CREATED_BY" => $idUser, 
                "MODIFIED_BY" => $idUser, 
                "IBLOCK_SECTION_ID" => false,
                "IBLOCK_ID" => $arParams["IBLOCK_ADD_ID"],
                "PROPERTY_VALUES"=> $PROP,
                "NAME"           => getMessage("IR_TITLE_IBLOCK_ELEMENT", ["#AUTHOR#" => $arResult["FEILDS"]["user_surname"] . " " . $arResult["FEILDS"]["user_name"] . " " . $arResult["FEILDS"]["user_second_name"], "#THEME#" => $arResult["FEILDS"]["theme"]]),
                "ACTIVE"         => "Y", 
                "DATE_ACTIVE_FROM" => ConvertTimeStamp(time(), "FULL", SITE_ID)
            );
            $el = new CIBlockElement;
            $el->Add($arLoadProductArray);

			$_SESSION["IR_NAME"] = $arResult["FEILDS"]["user_name"];
            $_SESSION["IR_SURNAME"] = $arResult["FEILDS"]["user_surname"];
            $_SESSION["IR_SECOND_NAME"] = $arResult["FEILDS"]["user_second_name"];
			$_SESSION["IR_EMAIL"] = $arResult["FEILDS"]["user_email"];
	     	
            if($arPost["ajax"] === "y"){
                $GLOBALS['APPLICATION']->RestartBuffer(); 
                $arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];
                if($arParams["USE_CAPTCHA"] == "Y"){
                    $arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());
                }
                echo json_encode($arResult);
                die() ;
            } else {
                if(!empty($arResult["REG_MESSAGE"])){
                    LocalRedirect($APPLICATION->GetCurPageParam("success=".$arResult["PARAMS_HASH"]."&reg=" . $arResult["REG_MESSAGE"], Array("success", "reg")));
                } else {
                    LocalRedirect($APPLICATION->GetCurPageParam("success=".$arResult["PARAMS_HASH"], Array("success", "reg")));
                }
            }
		}

	}else{
        $arResult["ERROR_MESSAGE"][] = GetMessage("IR_SESS_EXP");
    }
		
} elseif($request->get("success") == $arResult["PARAMS_HASH"]){
	$arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];
    $arResult["REG_MESSAGE"] = $request->get("reg");
}

if(empty($arResult["ERROR_MESSAGE"])){
	if($USER->IsAuthorized()){
		$arResult["FEILDS"]["user_name"] = $USER->GetFirstName();
        $arResult["FEILDS"]["user_surname"] = $USER->GetLastName();
        $arResult["FEILDS"]["user_second_name"] = $USER->GetParam("SECOND_NAME");
		$arResult["FEILDS"]["user_email"] = htmlspecialcharsbx($USER->GetEmail());
	}else{
		if(strlen($_SESSION["IR_NAME"]) > 0){
            $arResult["FEILDS"]["user_name"] = htmlspecialcharsbx($_SESSION["IR_NAME"]);
        }
        if(strlen($_SESSION["IR_SURNAME"]) > 0){
            $arResult["FEILDS"]["user_surname"] = htmlspecialcharsbx($_SESSION["IR_SURNAME"]);
        }
        if(strlen($_SESSION["IR_SECOND_NAME"]) > 0){
            $arResult["FEILDS"]["user_second_name"] = htmlspecialcharsbx($_SESSION["IR_SECOND_NAME"]);
        }
		if(strlen($_SESSION["IR_EMAIL"]) > 0){
            $arResult["FEILDS"]["user_email"] = htmlspecialcharsbx($_SESSION["IR_EMAIL"]);
        }	
	}
}

if($arParams["USE_CAPTCHA"] == "Y"){
    $arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());
}
	
if($arPost["ajax"] === "y"){
    $GLOBALS['APPLICATION']->RestartBuffer(); 
    echo json_encode($arResult);
    die();
} else {
    $this->IncludeComponentTemplate();
}  