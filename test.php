<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');

//require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("");
//if (!CModule::IncludeModule("main")) {
//    die("Модуль main не подключен!");
//}
//$dbRes = CEventMessage::GetList($by = "id", $order = "desc", ["EVENT_NAME" => "NEW_DEVICE_LOGIN"]);
//if (!$dbRes->Fetch()) {
//    die("Почтовый шаблон не найден!");
//}


//$result = CEvent::Send("NEW_DEVICE_LOGIN", "s1", [
//    "EMAIL" => "i.mirkin@yandex.ru",
//    "EMAIL_TO" => "i.mirkin@yandex.ru",
//    "TEXT" => "Тестовое письмо"
//]);
//
//if ($result) {
//    echo "Письмо отправлено!";
//} else {
//    echo "Ошибка при отправке письма!";
//}
?>

<?

//$APPLICATION->IncludeComponent(
//	"bitrix:subscribe.edit",
//	"clear",
//	Array(
//		"AJAX_MODE" => "N",
//		"AJAX_OPTION_ADDITIONAL" => "",
//		"AJAX_OPTION_HISTORY" => "N",
//		"AJAX_OPTION_JUMP" => "N",
//		"AJAX_OPTION_STYLE" => "Y",
//		"ALLOW_ANONYMOUS" => "Y",
//		"CACHE_TIME" => "3600",
//		"CACHE_TYPE" => "A",
//		"SET_TITLE" => "Y",
//		"SHOW_AUTH_LINKS" => "Y",
//		"SHOW_HIDDEN" => "N"
//	)
//);

?>

<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>