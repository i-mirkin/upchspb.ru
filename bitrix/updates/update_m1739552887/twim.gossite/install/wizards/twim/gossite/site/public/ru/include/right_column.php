<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Loader;
Loader::includeModule("twim.gossite");
?>
<a class="banner-question" href="javascript:void(0)" data-toggle="modal_classic" data-target="#modal_question" data-title="Задать вопрос:" data-load-page="#SITE_DIR#appeals/vopros-otvet/question.php">
     <div>Задать вопрос <i class="icom icon-question" aria-hidden="true"></i> </div>
 </a>
 <?
 $flag_doc_detect = strpos($requestPage, SITE_DIR.'official-documents/documents/');
 if ($flag_doc_detect === false):?>
 <div class="box">
     <div class="box-title">
         <h4>Документы</h4>
     </div>
     <div class="box-body">
         <div class="wrap-doc-list">                       
             <?$APPLICATION->IncludeComponent(
                     "bitrix:news.list", 
                     "docs_list", 
                     array(
                         "ACTIVE_DATE_FORMAT" => "d F Y H:i",
                         "ADD_SECTIONS_CHAIN" => "N",
                         "AJAX_MODE" => "N",
                         "AJAX_OPTION_ADDITIONAL" => "",
                         "AJAX_OPTION_HISTORY" => "N",
                         "AJAX_OPTION_JUMP" => "N",
                         "AJAX_OPTION_STYLE" => "Y",
                         "CACHE_FILTER" => "Y",
                         "CACHE_GROUPS" => "Y",
                         "CACHE_TIME" => "36000000",
                         "CACHE_TYPE" => "A",
                         "CHECK_DATES" => "Y",
                         "DETAIL_URL" => "",
                         "DISPLAY_BOTTOM_PAGER" => "N",
                         "DISPLAY_DATE" => "Y",
                         "DISPLAY_NAME" => "Y",
                         "DISPLAY_PICTURE" => "N",
                         "DISPLAY_PREVIEW_TEXT" => "Y",
                         "DISPLAY_TOP_PAGER" => "N",
                         "FIELD_CODE" => array(
                             0 => "DETAIL_TEXT",
                             1 => "",
                         ),
                         "FILE_404" => "",
                         "FILTER_NAME" => "arrFilterDocs",
                         "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                         "IBLOCK_ID" => "#NPA_IBLOCK_ID#",
                         "IBLOCK_TYPE" => "documents",
                         "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                         "INCLUDE_SUBSECTIONS" => "N",
                         "MESSAGE_404" => "",
                         "NEWS_COUNT" => "3",
                         "PAGER_BASE_LINK_ENABLE" => "N",
                         "PAGER_DESC_NUMBERING" => "N",
                         "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                         "PAGER_SHOW_ALL" => "N",
                         "PAGER_SHOW_ALWAYS" => "N",
                         "PAGER_TEMPLATE" => ".default",
                         "PAGER_TITLE" => "Новости",
                         "PARENT_SECTION" => "",
                         "PARENT_SECTION_CODE" => "",
                         "PREVIEW_TRUNCATE_LEN" => "210",
                         "PROPERTY_CODE" => array(
                             0 => "",
                             1 => "FILE",
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
                         "COMPONENT_TEMPLATE" => "docs_list"
                     ),
                     false
                 );?>
             <a href="#SITE_DIR#official-documents/documents/" class="btn btn-info btn-sm pull-right">Все документы</a>
         </div>
     </div>
 </div>
 <?endif;?>
 <?if ($requestPage  !== SITE_DIR.'news/index.php'):?>
     <div class="box">
         <div class="box-title">
             <h4>Новости</h4>
         </div>
         <div class="box-body">
             <?$current_news_id = TwimGossite\Helpers\GarbageStorage::get("detail_news_id");
             if(!empty($current_news_id)){
                 $GLOBALS['arrFilterNews'] = array("!ID" => $current_news_id);
             }
             $APPLICATION->IncludeComponent("bitrix:news.list", "news_list", Array(
                 "ACTIVE_DATE_FORMAT" => "d F Y H:i",	// Формат показа даты
                     "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
                     "AJAX_MODE" => "N",	// Включить режим AJAX
                     "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
                     "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
                     "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
                     "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
                     "CACHE_FILTER" => "Y",	// Кешировать при установленном фильтре
                     "CACHE_GROUPS" => "Y",	// Учитывать права доступа
                     "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
                     "CACHE_TYPE" => "A",	// Тип кеширования
                     "CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
                     "DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
                     "DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
                     "DISPLAY_DATE" => "Y",	// Выводить дату элемента
                     "DISPLAY_NAME" => "Y",	// Выводить название элемента
                     "DISPLAY_PICTURE" => "N",	// Выводить изображение для анонса
                     "DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
                     "DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
                     "FIELD_CODE" => array(	// Поля
                         0 => "DETAIL_TEXT",
                         1 => "",
                     ),
                     "FILE_404" => "",	// Страница для показа (по умолчанию /404.php)
                     "FILTER_NAME" => "arrFilterNews",	// Фильтр
                     "HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
                     "IBLOCK_ID" => "#NEWS_IBLOCK_ID#",	// Код информационного блока
                     "IBLOCK_TYPE" => "news",	// Тип информационного блока (используется только для проверки)
                     "INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
                     "INCLUDE_SUBSECTIONS" => "N",	// Показывать элементы подразделов раздела
                     "MESSAGE_404" => "",
                     "NEWS_COUNT" => "3",	// Количество новостей на странице
                     "PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
                     "PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
                     "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
                     "PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
                     "PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
                     "PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
                     "PAGER_TITLE" => "Новости",	// Название категорий
                     "PARENT_SECTION" => "",	// ID раздела
                     "PARENT_SECTION_CODE" => "",	// Код раздела
                     "PREVIEW_TRUNCATE_LEN" => "210",	// Максимальная длина анонса для вывода (только для типа текст)
                     "PROPERTY_CODE" => array(	// Свойства
                         0 => "LINK_VIDEO",
                         1 => "MORE_PHOTOS",
                     ),
                     "SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
                     "SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
                     "SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
                     "SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
                     "SET_STATUS_404" => "Y",	// Устанавливать статус 404
                     "SET_TITLE" => "N",	// Устанавливать заголовок страницы
                     "SHOW_404" => "N",	// Показ специальной страницы
                     "SORT_BY1" => "ACTIVE_FROM",	// Поле для первой сортировки новостей
                     "SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
                     "SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
                     "SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
                     "COMPONENT_TEMPLATE" => ".default"
                 ),
                 false
             );?>
             <a href="#SITE_DIR#news/" class="btn btn-info btn-sm pull-right">Все новости</a>
         </div>
     </div>
 <?endif;?>   