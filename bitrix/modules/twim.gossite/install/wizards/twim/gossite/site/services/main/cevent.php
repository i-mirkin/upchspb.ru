<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
if (WIZARD_INSTALL_DEMO_DATA)
{
    // IR_NEW_USER  
    $arFilter = array(
        "TYPE_ID" => "IR_NEW_USER",
        "LID"     => "ru"
    );
    $rsET = CEventType::GetList($arFilter);
    $arET = $rsET->Fetch();
    if($arET){
        $emess = new CEventMessage;
        $id_message = $emess->Add(array(
            "ACTIVE" => "Y",
            "EVENT_NAME" => "IR_NEW_USER",
            "LID" => WIZARD_SITE_ID,
            "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
            "EMAIL_TO" => "#EMAIL#",
            "SUBJECT" => getMessage("GOSSITE_IR_NEW_USER_SUBJECT"),
            "MESSAGE" => getMessage("GOSSITE_IR_NEW_USER_MESSAGE"),
            "BODY_TYPE" => "text"
        ));	
    }
    
    // IR_FEEDBACK_FORM  
    $arFilter = array(
        "TYPE_ID" => "IR_FEEDBACK_FORM",
        "LID"     => "ru"
    );
    $rsET = CEventType::GetList($arFilter);
    $arET = $rsET->Fetch();
    if($arET){
        $emess = new CEventMessage;
        $id_message = $emess->Add(array(
            "ACTIVE" => "Y",
            "EVENT_NAME" => "IR_FEEDBACK_FORM",
            "LID" => WIZARD_SITE_ID,
            "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
            "EMAIL_TO" => "#EMAIL_TO#",
            "SUBJECT" => getMessage("GOSSITE_IR_FEEDBACK_FORM_SUBJECT"),
            "MESSAGE" => getMessage("GOSSITE_IR_FEEDBACK_FORM_MESSAGE"),
            "BODY_TYPE" => "html",
        ));	
        
        CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/appeals/internet-reception/new/index.php", array("IR_FEEDBACK_FORM_MESSAGE_ID" => $id_message));
        
        $emess = new CEventMessage;
        $id_message = $emess->Add(array(
            "ACTIVE" => "Y",
            "EVENT_NAME" => "IR_FEEDBACK_FORM",
            "LID" => WIZARD_SITE_ID,
            "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
            "EMAIL_TO" => "#E_MAIL_AUTHOR#",
            "SUBJECT" => getMessage("GOSSITE_IR_FEEDBACK_FORM_USER_SUBJECT"),
            "MESSAGE" => getMessage("GOSSITE_IR_FEEDBACK_FORM_USER_MESSAGE"),
            "BODY_TYPE" => "html",
        ));	
        
        CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/appeals/internet-reception/new/index.php", array("IR_FEEDBACK_FORM_USER_MESSAGE_ID" => $id_message));
    }
	
    // IR_ADD_ANSWER  
    $arFilter = array(
        "TYPE_ID" => "IR_ADD_ANSWER",
        "LID"     => "ru"
    );
    $rsET = CEventType::GetList($arFilter);
    $arET = $rsET->Fetch();
    if($arET){
        $emess = new CEventMessage;
        $id_message = $emess->Add(array(
            "ACTIVE" => "Y",
            "EVENT_NAME" => "IR_ADD_ANSWER",
            "LID" => WIZARD_SITE_ID,
            "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
            "EMAIL_TO" => "#E_MAIL_AUTHOR# ",
            "SUBJECT" => getMessage("GOSSITE_IR_ADD_ANSWER_SUBJECT"),
            "MESSAGE" => getMessage("GOSSITE_IR_ADD_ANSWER_MESSAGE"),
            "BODY_TYPE" => "html",
        ));	
    }
    
    // IR_CHANGE_STATUS  
    $arFilter = array(
        "TYPE_ID" => "IR_CHANGE_STATUS",
        "LID"     => "ru"
    );
    $rsET = CEventType::GetList($arFilter);
    $arET = $rsET->Fetch();
    if($arET){
        $emess = new CEventMessage;
        $id_message = $emess->Add(array(
            "ACTIVE" => "Y",
            "EVENT_NAME" => "IR_CHANGE_STATUS",
            "LID" => WIZARD_SITE_ID,
            "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
            "EMAIL_TO" => "#E_MAIL_AUTHOR# ",
            "SUBJECT" => getMessage("GOSSITE_IR_CHANGE_STATUS_SUBJECT"),
            "MESSAGE" => getMessage("GOSSITE_IR_CHANGE_STATUS_MESSAGE"),
            "BODY_TYPE" => "html",
        ));	
    }

    // FEEDBACK_FORM   add new template post
    $arFilter = array(
        "TYPE_ID" => "FEEDBACK_FORM",
        "LID"     => "ru"
    );
    $rsET = CEventType::GetList($arFilter);
    $arET = $rsET->Fetch();
    if($arET){
        $arr["ACTIVE"] = "Y";
        $arr["EVENT_NAME"] = "FEEDBACK_FORM";
        $arr["LID"] = WIZARD_SITE_ID;
        $arr["EMAIL_FROM"] = "#DEFAULT_EMAIL_FROM#";
        $arr["EMAIL_TO"] = "#EMAIL_TO#";
        $arr["BCC"] = "#BCC#";
        $arr["SUBJECT"] =  getMessage("MAIN_OPT_FEEDBACK_SUBJECT");
        $arr["BODY_TYPE"] = "html";
        $arr["MESSAGE"] = getMessage("MAIN_OPT_FEEDBACK_MESSAGE");
        $emess = new CEventMessage;
        $id_message = $emess->Add($arr);
        CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/anti-corruption/report-corruption/index.php", array("ANTICOR_EVENT_MESSAGE_ID" => $id_message));
    }
		
	$arFilter = array(
		"TYPE_ID" => "QUESTION_FORM",
		"LID"     => "ru"
	);
	$rsET = CEventType::GetList($arFilter);
	$arET = $rsET->Fetch();
	if($arET){
		$emess = new CEventMessage;
		$id_message = $emess->Add(array(
			"ACTIVE" => "Y",
			"EVENT_NAME" => "QUESTION_FORM",
			"LID" => WIZARD_SITE_ID,
			"EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
			"EMAIL_TO" => "#EMAIL_TO#",
			"SUBJECT" => GetMessage("GOSSITE_QUESTION_FORM_SUBJECT"),
			"MESSAGE" => GetMessage("GOSSITE_QUESTION_FORM_MESSAGE"),
			"BODY_TYPE" => "text",
		));		
        CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/appeals/vopros-otvet/question.php", array("QUIESTION_EVENT_MESSAGE_ID" => $id_message));
        
	}

	$arFilter = array(
		"TYPE_ID" => "ANSWER_FORM",
		"LID"     => "ru"
	);
	$rsET = CEventType::GetList($arFilter);
	$arET = $rsET->Fetch();
	if($arET){
		$emess = new CEventMessage;
		$emess->Add(array(
			"ACTIVE" => "Y",
			"EVENT_NAME" => "ANSWER_FORM",
			"LID" => WIZARD_SITE_ID,
			"EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
			"EMAIL_TO" => "#EMAIL_TO#",
			"SUBJECT" => GetMessage("GOSSITE_ANSWER_FORM_SUBJECT"),
			"MESSAGE" => GetMessage("GOSSITE_ANSWER_FORM_MESSAGE"),
			"BODY_TYPE" => "text",
		));			
	}	
	
	
    
}
