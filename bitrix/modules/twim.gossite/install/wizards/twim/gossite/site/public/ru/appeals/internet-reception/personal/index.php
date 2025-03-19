<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет ");
?>
<p>Вы зарегистрированы и успешно авторизовались.</p>
<p><a href="<?=SITE_DIR?>appeals/internet-reception/">Создать обращение</a></p>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>