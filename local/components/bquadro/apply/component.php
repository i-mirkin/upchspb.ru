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
//\Bitrix\Main\Diag\Debug::writeToFile(['arParams'=>$arParams],'','/arParams_apply.txt');
$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());

$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
if($arParams["EVENT_NAME"] == '')
	$arParams["EVENT_NAME"] = "QUESTION_FORM";
$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
if($arParams["EMAIL_TO"] == '')
	$arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
$arParams["OK_TEXT"] = trim($arParams["OK_TEXT"]);
if($arParams["OK_TEXT"] == '')
	$arParams["OK_TEXT"] = GetMessage("MF_OK_MESSAGE");

$respArr = [
	'success_msg' => $arParams["OK_TEXT"] 
];
$arError = [];
$arError["FILE"] = '';
if($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"]))
{

    if(($_POST["AJAX_PAGE"]) === "Y" && LANG_CHARSET === 'windows-1251'){
        $_POST["user_name"] = iconv('UTF-8', 'windows-1251', $_POST["user_name"]);
        $_POST["user_email"] = iconv('UTF-8', 'windows-1251', $_POST["user_email"]);
        $_POST["MESSAGE"] = iconv('UTF-8', 'windows-1251', $_POST["MESSAGE"]);
    }
    
	$arResult["ERROR_MESSAGE"] = array();
	if(check_bitrix_sessid())
	{
		if(empty($arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $arParams["REQUIRED_FIELDS"]))
		{
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_name"]) <= 1)
				$arResult["ERROR_MESSAGE"]['user_name'] = GetMessage("MF_REQ_NAME");		
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("SURNAME", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_surname"]) <= 1)
				$arResult["ERROR_MESSAGE"]['user_surname'] = GetMessage("MF_REQ_SURNAME");
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("PATRONYMIC", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_patronymic"]) <= 1)
				$arResult["ERROR_MESSAGE"]['user_patronymic'] = GetMessage("MF_REQ_PATRONYMIC");		
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_email"]) <= 1)
				$arResult["ERROR_MESSAGE"]['user_email'] = GetMessage("MF_REQ_EMAIL");
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_phone"]) <= 1)
				$arResult["ERROR_MESSAGE"]['user_phone'] = GetMessage("MF_REQ_PHONE");
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("UPOSTADDR", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_postaddr"]) <= 1)
				$arResult["ERROR_MESSAGE"]['user_postaddr'] = GetMessage("MF_REQ_POSTADDR");
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["MESSAGE"]) <= 3)
				$arResult["ERROR_MESSAGE"]['MESSAGE'] = GetMessage("MF_REQ_MESSAGE");
			if(empty($_FILES["FILE"]['size'][0]) || empty($_FILES["FILE"]['name'][0])) {
			    $arResult["ERROR_MESSAGE"]['FILE'] = GetMessage("MF_REQ_FILE");
			}
		}
		if(strlen($_POST["user_email"]) > 1 && !check_email($_POST["user_email"])) 
			$arResult["ERROR_MESSAGE"]['user_email'] = GetMessage("MF_EMAIL_NOT_VALID");
		
		$qcapt = $_POST['app_capt'] ?: '';
		if(empty($qcapt) || $qcapt != 'Y') {
			$arResult["ERROR_MESSAGE"][] = GetMessage("SPAM_ERROR");
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
		if(empty($arResult["ERROR_MESSAGE"]))
		{
            
            $arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);
            if($arParams["IBLOCK_ID"] >0 ){
               
                // add new elements
                Loader::includeModule("iblock");

                $el = new CIBlockElement;

                $PROP = array();
                $PROP["USER"] = $_POST["user_name"];    
                $PROP["EMAIL"] = $_POST["user_email"];     
				$PROP["PHONE"] = $_POST["user_phone"]; 
				$PROP["postaddr"] = $_POST["user_postaddr"];

                $sendRespEmail = '';
				if($_POST['send_resp_email']) $sendRespEmail = '<br>'.GetMessage('SRE').'<br>';
				
				if ($_FILES["FILE"]) {	
                    unset($_SESSION['FILE']);
                    $fileList = [];
                    $fileKeys = ['name', 'type', 'tmp_name', 'error', 'size'];  
                    foreach($fileKeys as $fileKey) {
                    	foreach($_FILES["FILE"][$fileKey] as $f => $fileProp) {
                    		if(empty($fileProp)) continue;
                            $fileList[$f][$fileKey] = $fileProp;
                    	}
                    }
                    /*dump($_FILES["FILE"]); 
                    dump($fileList); die(__FILE__);*/

                    $file_format = array('txt', 'rtf', 'pdf', 'doc', 'docx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', "xls", "xlsx", 'rar', 'zip', '7z', 'sig');
                    foreach($fileList as $kf => &$fileListEl) { 
                        preg_match("/.+\.(.*?)$/i", $fileListEl["name"], $a);
					    if (file_exists($fileListEl["tmp_name"])) {
						if($fileListEl["size"] < 10485760) {
							if (in_array(strtolower($a[1]), $file_format)) {
								$tmp_url = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/tmp/" . $fileListEl["name"];
								if (file_exists($tmp_url)) {
									unlink($tmp_url);
								}
								copy($fileListEl["tmp_name"], $tmp_url);
								$fileListEl["tmp_name"] = $tmp_url;
								$_SESSION['FILE'][$kf] = $fileListEl;
                                
							} else {
								$arError["FILE"] = "Неверный формат файла ".$fileListEl["name"];								
								unlink($_SESSION['FILE'][$kf]["tmp_name"]);
								unset($_SESSION['FILE'][$kf]);
							}
						} else {							
							$arError["FILE"] = "Размер файла превышает 10 MB!";
							unlink($_SESSION['FILE'][$kf]["tmp_name"]);
							unset($_SESSION['FILE'][$kf]);	
						}
					    }
                    }

				} else {
					unlink($_SESSION['FILE']["tmp_name"]);
					unset($_SESSION['FILE']);
				}                

                $sf = 0;
                foreach($_SESSION["FILE"] as $sfile) {
                    if (is_file($sfile["tmp_name"])) {
                        $PROP["FILE"]['n'.$sf] = [                             
                            "VALUE" => CFile::MakeFileArray($sfile["tmp_name"])                            
                        ];
                    }   
                    $sf++;             	
                }                

				/*if (is_file($_SESSION["FILE"]["tmp_name"])) {
					$PROP["FILE"] = CFile::MakeFileArray($_SESSION['FILE']["tmp_name"]);					
				}*/
				
                $db_props = CIBlockProperty::GetByID("AUHTOR_ANSWER", $arParams["IBLOCK_ID"]);
                if($ar_res = $db_props->GetNext()){
                   $PROP["AUHTOR_ANSWER"] = $ar_res["DEFAULT_VALUE"];     
                }

                $arLoadProductArray = Array(
                    "DATE_ACTIVE_FROM" => ConvertTimeStamp(false, "FULL"),
                    "IBLOCK_SECTION_ID" => false,
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "PROPERTY_VALUES" => $PROP,
                    "NAME" => $_POST["user_name"],					
                    "ACTIVE" => "N",
                    "PREVIEW_TEXT" => $_POST["MESSAGE"],
                );
				
				if(empty($arError["FILE"])) {
					$id_elements = $el->Add($arLoadProductArray);
					$elementLink = "//". $_SERVER['SERVER_NAME'] . "/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=".$arParams["IBLOCK_ID"]."&type=apply&ID=".$id_elements."&lang=ru&find_section_section=-1&WF=Y";
					$elementLinkEl = '<a href="'.$elementLink.'">Подробнее</a>';
				}
            }
            
			$arFields = Array(
				"AUTHOR" => $_POST["user_name"],
				"SURNAME" => $_POST["user_surname"],
                "PATRONYMIC" => $_POST["user_patronymic"],   
				"AUTHOR_EMAIL" => $_POST["user_email"],
				"PHONE" => $PROP["PHONE"],
				"POSTADDR" => $PROP["postaddr"],
				"EMAIL_TO" => $arParams["EMAIL_TO"],
				"TEXT" => $_POST["MESSAGE"],
				"ELEMENT_LINK" => $elementLinkEl,
				"SRE" => $sendRespEmail,
			    "FILE_LIST" => ''
			);

            if($id_elements){
                $arFields["IBLOCK_ID"] = $arParams["IBLOCK_ID"];
                $arFields["ID"] = $id_elements;
            }
			
            $sendFiles = [];
            
            $sendFilesList = [];
            $flBlock = '';
            $mailSize = $sendFilesSize = $messageSize = 0;
            foreach($PROP["FILE"] as $propF) {
                $sendFilesSize += $propF['VALUE']['size'];
            }
            $messageSize = strlen($_POST["MESSAGE"]);
            $mailSize = $sendFilesSize + $messageSize;
            if($mailSize > 24000000 && $id_elements) {
                $elFilesList = \CIBlockElement::GetProperty(34,$id_elements, array(),['CODE'=>'FILE']);
                while ($elFilesListob = $elFilesList->GetNext())
                {
                    $sendFilesList[] = "//". $_SERVER['SERVER_NAME'] . '/' . \CFile::GetPath($elFilesListob['VALUE']);
                }
                
                if(!empty($sendFilesList)) {
                    $flBlock = '<p>Прикрепленные файлы: </p>';
                    foreach($sendFilesList as $k => $v) {
                        $flBlock .= '<p><a href="'.$v.'">Файл '.$k.'</a></p>';
                    }
                }
                
                $arFields['FILE_LIST'] = $flBlock;
            }
            
            if(empty($flBlock)) {
                foreach($PROP["FILE"] as $propF) {
                	$sendFiles[] = $propF['VALUE']['tmp_name'];
                }     
            }

			if(empty($arError["FILE"])) { 
				switch(SITE_ID) {
					case 's1':
						CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "Y", 40);		
						CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "Y", 41, $sendFiles);  
					break;
					case 'en':
						CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "Y", 49);
						CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "Y", 48, $sendFiles); 
					break;
				}				
				
			} else {
				$respArr = [
					'error_msg' => $arError["FILE"] ,
					'IS_ERROR' => 1
				];
			}
			
			$_SESSION["MF_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
			$_SESSION["MF_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
			$_SESSION["MF_PHONE"] = htmlspecialcharsbx($_POST["user_phone"]);
			
			$APPLICATION->RestartBuffer();
			echo json_encode($respArr);
			exit();
		} else {
			$arResult["ERROR_MESSAGE"]['IS_ERROR'] = 1;
			$arResult["ERROR_MESSAGE"]['error_msg'] = GetMessage('FIELDS_ERROR');
			$APPLICATION->RestartBuffer();
			echo json_encode($arResult["ERROR_MESSAGE"]);
			exit();
		}
		
		$arResult["MESSAGE"] = htmlspecialcharsbx($_POST["MESSAGE"]);
		$arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
		$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
		$arResult["AUTHOR_PHONE"] = htmlspecialcharsbx($_POST["user_phone"]);
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
		$arResult["AUTHOR_NAME"] = $USER->GetFormattedName(false);
		$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
	}
	else
	{
		if(strlen($_SESSION["MF_NAME"]) > 0)
			$arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
		if(strlen($_SESSION["MF_EMAIL"]) > 0)
			$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
		if(strlen($_SESSION["MF_PHONE"]) > 0)
			$arResult["AUTHOR_PHONE"] = htmlspecialcharsbx($_SESSION["MF_PHONE"]);
	}
}

if($arParams["USE_CAPTCHA"] == "Y")
	$arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

$this->IncludeComponentTemplate();
