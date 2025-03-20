<?
define("NEED_AUTH", true); // выводит CMain::AuthForm выводится system.auth.authorize
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @global CMain $APPLICATION */
/** @var string $iconDoc */
/** @var string $iconDocNew */
/** @var string $iconDocComplete */

$APPLICATION->SetTitle("Персональный раздел");
$APPLICATION->SetPageProperty("title", "Персональный раздел");
?>
<a href="/personal/questions/" class="btn--personal">Вопрос-ответ</a>
<br>
<br>
<br>
<a href="/personal/appointment/" class="btn--personal">Запись на прием</a>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>