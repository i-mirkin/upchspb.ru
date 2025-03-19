<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetPageProperty("OG:DESCRIPTION", "Official website of the Human Rights Ombudsman in Saint Petersburg");
$APPLICATION->SetPageProperty("OG:TITLE", "Official website of the Human Rights Ombudsman in Saint Petersburg");
$APPLICATION->SetPageProperty("title", "Official website of the Human Rights Ombudsman in Saint Petersburg");
$APPLICATION->SetPageProperty("description", "Official website of the Human Rights Ombudsman in Saint Petersburg");
$APPLICATION->SetTitle("Home");
?> 
             <div class="col-left">
	            <?if($IS_MAIN == 'Y' && $themeConfig['main_page']['slider'] === "Y"):?>
					<?$APPLICATION->IncludeFile(
						SITE_DIR."include/slider_main.php",
						Array(),
						Array("MODE"=>"text")
					);?> 
				<?endif;?>
				
					<?if(($themeConfig['main_page']["news"] == "list")){
						$templateMainNews = "news_list";
					} else {
						$templateMainNews = "news_list_main";
					}?>
					<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"news_list_main", 
	array(
		"ACTIVE_DATE_FORMAT" => "d F Y H:i",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "DETAIL_TEXT",
			1 => "",
		),
		"FILE_404" => "",
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "5",
		"IBLOCK_TYPE" => "news",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "100",
		"PROPERTY_CODE" => array(
			0 => "SOURCE",
			1 => "MAIN_SHOW",
			2 => "LINK_VIDEO",
			3 => "THEME",
			4 => "MAIN_NEWS",
			5 => "BREAKING_NEWS",
			6 => "TAG_LINK",
			7 => "DATE",
			8 => "MORE_PHOTOS",
			9 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"COMPONENT_TEMPLATE" => "news_list_main",
		"STRICT_SECTION_CHECK" => "N"
	),
	false
);?>					
                      
                 <?if($themeConfig['main_page']['media'] === "Y"):?>

					 <?$APPLICATION->IncludeComponent(
							"bquadro:photo.sections.top", 							
							"albom_list_main", 
							array(
								"CACHE_FILTER" => "N",
								"CACHE_GROUPS" => "Y",
								"CACHE_TIME" => "36000000",
								"CACHE_TYPE" => "A",
								"DETAIL_URL" => "",
								"ELEMENT_COUNT" => "1",
								"ELEMENT_SORT_FIELD" => "sort",
								"ELEMENT_SORT_ORDER" => "asc",
								"FIELD_CODE" => array(
									0 => "",
									1 => "",
								),
								"FILTER_NAME" => "arrFilter",
								"IBLOCK_ID" => "6",
								"IBLOCK_TYPE" => "media",
								"LINE_ELEMENT_COUNT" => "1",
								"PROPERTY_CODE" => array(
									0 => "",
									1 => "",
								),
								"SECTION_COUNT" => "3",
								"SECTION_FIELDS" => array(
									0 => "",
									1 => "",
								),
								"SECTION_SORT_FIELD" => "sort",
								"SECTION_SORT_ORDER" => "asc",
								"SECTION_URL" => "",
								"SECTION_USER_FIELDS" => array(
									0 => "",
									1 => "",
								),
								"COMPONENT_TEMPLATE" => "albom_list_main"
							),
							false
						);?>

                 <?endif;?>
				
				<?$APPLICATION->IncludeComponent(
	"bquadro:add.main", 
	".default", 
	array(
		"prop_code" => "42",
		"box_title" => "",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
				
                 <?if($themeConfig['main_page']['banners'] === "Y"):?>
                 <?$APPLICATION->IncludeComponent("bitrix:news.list", "partners", Array(
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
		"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
		"DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
		"DISPLAY_DATE" => "N",	// Выводить дату элемента
		"DISPLAY_NAME" => "Y",	// Выводить название элемента
		"DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
		"DISPLAY_PREVIEW_TEXT" => "N",	// Выводить текст анонса
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"FIELD_CODE" => array(	// Поля
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",	// Фильтр
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
		"IBLOCK_ID" => "21",	// Код информационного блока
		"IBLOCK_TYPE" => "media",	// Тип информационного блока (используется только для проверки)
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
		"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
		"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
		"NEWS_COUNT" => "20",	// Количество новостей на странице
		"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
		"PAGER_TITLE" => "Новости",	// Название категорий
		"PARENT_SECTION" => "",	// ID раздела
		"PARENT_SECTION_CODE" => "",	// Код раздела
		"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
		"PROPERTY_CODE" => array(	// Свойства
			0 => "LINK",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
		"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
		"SET_STATUS_404" => "N",	// Устанавливать статус 404
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SHOW_404" => "N",	// Показ специальной страницы
		"SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
		"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
		"SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
		"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
	),
	false,
	["ACTIVE_COMPONENT"=>"N"]
);?>
                <?endif;?>
                <?if($themeConfig['main_page']['contacts'] === "Y"):?>
                <div class="box">
                <?$APPLICATION->IncludeFile(
                    SITE_DIR."/include/contacts_block.php",
                    Array("OPTION_SITE" => $arOptionGosSite),
                    Array("MODE"=>"text", "SHOW_BORDER" => false)
                );?> 
                </div>
                <?endif;?> 
				
			</div>		 

<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');?>