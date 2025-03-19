<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("og:title", "Подать заявление");
$APPLICATION->SetPageProperty("title", "Подать заявление");
$APPLICATION->SetTitle("Подать заявление");
?><?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
	"AREA_FILE_SHOW" => "sect", 
	"AREA_FILE_SUFFIX" => "inc", 
	"AREA_FILE_RECURSIVE" => "Y", 
	"EDIT_TEMPLATE" => "standard.php" 
)
);?>


<?

// \bitrix\templates\.default\components\bquadro\apply\question_popup1\template.php

$APPLICATION->IncludeComponent(
	"bquadro:apply", 
	"question_popup1", 
	array(
		"COMPONENT_TEMPLATE" => "question_popup1",
		"EMAIL_TO" => $arOptionGosSite["email_form"],
		"EVENT_MESSAGE_ID" => array(
			0 => "41",
		),
		"EVENT_NAME" => "APPLY_FORM",
		"IBLOCK_ID" => "34",
		"IBLOCK_TYPE" => "apply",
		"OK_TEXT" => "Спасибо за обращение! ",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
			1 => "SURNAME",
			2 => "PHONE",
			3 => "EMAIL",
			4 => "MESSAGE",
			5 => "UPOSTADDR",
		),
		"USER_CONSENT" => "Y",
		"USER_CONSENT_ID" => "0",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"USE_CAPTCHA" => "Y"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>