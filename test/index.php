<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>

<p>REQUEST_URI = <?=REQUEST_URI?></p>

<p>defined(REQUEST_URI) = <?=(int)defined("REQUEST_URI");?></p>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>