<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("og:title", "Задать вопрос: Официальный сайт администрации");
$APPLICATION->SetPageProperty("title", "Задать вопрос");
$APPLICATION->SetTitle("Задать вопрос");
?>
<?$APPLICATION->IncludeComponent(
	"twim:question", 
	"question_popup", 
	array(
		"EMAIL_TO" => $arOptionGosSite["email_form"],
		"OK_TEXT" => "Спасибо за вопрос. Ответ Вы получите на указанную электронную почту.",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
			1 => "PHONE",
			2 => "EMAIL",
			3 => "MESSAGE",
			4 => "q_categ"
		),
		"EVENT_MESSAGE_ID" => array(
			0 => "38",
		),
		"USE_CAPTCHA" => "Y",
		"COMPONENT_TEMPLATE" => "question_popup",
		"IBLOCK_TYPE" => "vopros",
		"IBLOCK_ID" => "22",
		"USER_CONSENT" => "Y",
		"USER_CONSENT_ID" => "1",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>