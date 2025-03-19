<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
$APPLICATION->SetPageProperty("title", "Новости");
?><ul>
	<li><a href="/news/">Все новости</a></li>
	<li> <a href="/tag/">Новости по темам</a></li>
	<li> <a href="/information/smi-o-nas/">СМИ о нас</a></li>
</ul>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>