<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Вакансии");
$APPLICATION->SetTitle("Вакансии");
?>
<?$APPLICATION->IncludeComponent("bitrix:furniture.vacancies", "jobs_list", Array(
	"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"IBLOCK_ID" => "#JOBS_IBLOCK_ID#",	// Список инфоблоков
		"IBLOCK_TYPE" => "structure",	// Типы инфоблоков
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
