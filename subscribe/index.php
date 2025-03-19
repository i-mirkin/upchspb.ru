<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подписка на новости");
$context = \Bitrix\Main\Context::getCurrent();
$request = $context->getRequest();
$subsDel = $request->get('subs') ?: '';
?>
<? if('deleted' == $subsDel) { ?>
	<? echo ShowMessage(array("MESSAGE"=>'Ваша подписка на новостную рассылку Уполномоченного по правам человека в Санкт-Петербурге аннулирована.', "TYPE"=>"OK")); ?>
<? } else { ?>
	<?$APPLICATION->IncludeComponent("bitrix:subscribe.edit", "subs_edit", Array(
	"AJAX_MODE" => "N",	// Включить режим AJAX
		"SHOW_HIDDEN" => "N",	// Показать скрытые рубрики подписки
		"ALLOW_ANONYMOUS" => "Y",	// Разрешить анонимную подписку
		"SHOW_AUTH_LINKS" => "N",	// Показывать ссылки на авторизацию при анонимной подписке
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"AJAX_OPTION_SHADOW" => "Y",
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"COMPONENT_TEMPLATE" => ".default",
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
	),
	false
);?>
<? } ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>