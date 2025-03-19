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
		"OK_TEXT" => "Ваш вопрос отправлен",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
			1 => "EMAIL",
			2 => "MESSAGE",
		),
        "EVENT_MESSAGE_ID" => array(
			0 => "#QUIESTION_EVENT_MESSAGE_ID#",
		),
		"USE_CAPTCHA" => "Y",
		"COMPONENT_TEMPLATE" => "question_popup",
		"IBLOCK_TYPE" => "vopros",
		"IBLOCK_ID" => "#QUESTION_IBLOCK_ID#"
	),
	false
);?>
<a href="#SITE_DIR#appeals/vopros-otvet/question.php"><i class="ion ion-link margin-r-5"></i>ссылка на форму</a>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>