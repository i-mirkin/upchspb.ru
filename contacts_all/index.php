<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Контакты");
$APPLICATION->SetTitle("Контакты");
?><ul>
	<li><a href="/contacts_gr/">Для граждан</a></li>
	<li><a href="/contacts/">Для СМИ</a></li>
</ul>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>