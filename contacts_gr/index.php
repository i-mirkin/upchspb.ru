<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Контакты для граждан");
$APPLICATION->SetTitle("Контакты для граждан");
?> 

<?$APPLICATION->IncludeFile(
    SITE_DIR."/include/contacts_block.php",
    Array("OPTION_SITE" => $arOptionGosSite),
    Array("MODE"=>"text", "SHOW_BORDER" => false)
);?> 

<?/*$APPLICATION->IncludeComponent(
	"bitrix:main.feedback", 
	"question", 
	array(
		"EMAIL_TO" => $arOptionGosSite["email_form"],
		"EVENT_MESSAGE_ID" => array(
			0 => "7",
		),
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
			1 => "EMAIL",
			2 => "MESSAGE",
		),
		"USE_CAPTCHA" => "Y",
		"COMPONENT_TEMPLATE" => "question"
	),
	false
);*/?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>