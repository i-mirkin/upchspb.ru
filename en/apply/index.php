<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("og:title", "Apply");
$APPLICATION->SetPageProperty("title", "Apply");
$APPLICATION->SetTitle("Подать заявление");
?><?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
	"AREA_FILE_SHOW" => "sect", 
	"AREA_FILE_SUFFIX" => "inc", 
	"AREA_FILE_RECURSIVE" => "Y", 
	"EDIT_TEMPLATE" => "standard.php" 
)
);?>
<?$APPLICATION->IncludeComponent(
	"bquadro:apply", 
	"question_popup", 
	array(
		"COMPONENT_TEMPLATE" => "question_popup",
		"EMAIL_TO" => $arOptionGosSite["email_form"],
		"EVENT_MESSAGE_ID" => array(
			0 => "48",
			1 => "49",
		),
		"EVENT_NAME" => "APPLY_FORM",
		"IBLOCK_ID" => "48",
		"IBLOCK_TYPE" => "apply_en",
		"OK_TEXT" => "Your message has been send",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
			1 => "PHONE",
			2 => "EMAIL",
			3 => "MESSAGE",
		),
		"USER_CONSENT" => "Y",
		"USER_CONSENT_ID" => USER_AGREEMENT,
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"USE_CAPTCHA" => "N"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>