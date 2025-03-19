<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Главная');
?> 
 <div class="main-page">
     <div class="wrap-main-news">
         <div class="row">
             <div id="news-col-main" class="col-sm-8 col-md-9">
                 <div class="box">
                     <div class="box-title">
                         <h4>Новости</h4>
                     </div>
                     <div class="box-body">
                         <div class="wrap-news-list">
                            <?if(($themeConfig['main_page']["news"] == "list")){
                                $templateMainNews = "news_list";
                            } else {
                                $templateMainNews = "news_list_main";
                            }?>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:news.list", 
                                $templateMainNews, 
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
                                    "IBLOCK_ID" => "#NEWS_IBLOCK_ID#",
                                    "IBLOCK_TYPE" => "news",
                                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                    "INCLUDE_SUBSECTIONS" => "N",
                                    "MESSAGE_404" => "",
                                    "NEWS_COUNT" => "9",
                                    "PAGER_BASE_LINK_ENABLE" => "N",
                                    "PAGER_DESC_NUMBERING" => "N",
                                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                    "PAGER_SHOW_ALL" => "N",
                                    "PAGER_SHOW_ALWAYS" => "N",
                                    "PAGER_TEMPLATE" => ".default",
                                    "PAGER_TITLE" => "Новости",
                                    "PARENT_SECTION" => "",
                                    "PARENT_SECTION_CODE" => "",
                                    "PREVIEW_TRUNCATE_LEN" => "200",
                                    "PROPERTY_CODE" => array(
                                        0 => "LINK_VIDEO",
                                        1 => "MORE_PHOTOS",
                                        2 => "",
                                    ),
                                    "SET_BROWSER_TITLE" => "N",
                                    "SET_LAST_MODIFIED" => "N",
                                    "SET_META_DESCRIPTION" => "N",
                                    "SET_META_KEYWORDS" => "N",
                                    "SET_STATUS_404" => "Y",
                                    "SET_TITLE" => "N",
                                    "SHOW_404" => "N",
                                    "SORT_BY1" => "PROPERTY_FIX_NEWS", 
                                    "SORT_ORDER1" => "DESC", 
                                    "SORT_BY2" => "ACTIVE_FROM", 
                                    "SORT_ORDER2" => "DESC", 
                                    "COMPONENT_TEMPLATE" => "news_list_main"
                                ),
                                false
                            );?>
                            <a href="#SITE_DIR#news/" class="btn btn-info btn-sm pull-right">Все новости</a>
                         </div>
                     </div>
                 </div>      
                 <?if($themeConfig['main_page']['media'] === "Y"):?>
                 <div class="box hidden-print">
                     <div class="box-title">
                         <ul class="nav box-tabs" role="tablist">
                             <li role="presentation" class="active"><a href="#photo-main" aria-controls="photo-main" role="tab" data-toggle="tab">Фотогалерея</a></li>
                             <li role="presentation"><a href="#video-main" aria-controls="video-main" role="tab" data-toggle="tab">Видеогалерея</a></li>
                         </ul>
                     </div>
                     <div class="box-body">                        
                         <div class="wrap-gallery-main clearfix">
                             <div class="tab-content">
                                 <div role="tabpanel" class="tab-pane active fade in" id="photo-main">
                                     <?$APPLICATION->IncludeComponent(
                                            "bitrix:photo.sections.top", 
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
                                                "IBLOCK_ID" => "#PHOTOS_IBLOCK_ID#",
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
                                     <a href="#SITE_DIR#media/photo-gallery/" class="btn btn-info btn-sm pull-right">Все альбомы</a>
                                 </div>
                                 <div role="tabpanel" class="tab-pane fade" id="video-main">
                                     <?$APPLICATION->IncludeComponent("bitrix:news.list", "video_list_main", Array(
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
                                                "IBLOCK_ID" => "#VIDEO_IBLOCK_ID#",	// Код информационного блока
                                                "IBLOCK_TYPE" => "media",	// Тип информационного блока (используется только для проверки)
                                                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
                                                "INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
                                                "MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
                                                "NEWS_COUNT" => "3",	// Количество новостей на странице
                                                "PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
                                                "PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
                                                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
                                                "PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
                                                "PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
                                                "PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
                                                "PAGER_TITLE" => "Видео",	// Название категорий
                                                "PARENT_SECTION" => "",	// ID раздела
                                                "PARENT_SECTION_CODE" => "",	// Код раздела
                                                "PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
                                                "PROPERTY_CODE" => array(	// Свойства
                                                    0 => "LINK_YOUTUBE",
                                                    1 => "",
                                                ),
                                                "SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
                                                "SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
                                                "SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
                                                "SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
                                                "SET_STATUS_404" => "N",	// Устанавливать статус 404
                                                "SET_TITLE" => "N",	// Устанавливать заголовок страницы
                                                "SHOW_404" => "N",	// Показ специальной страницы
                                                "SORT_BY1" => "ACTIVE_FROM",	// Поле для первой сортировки новостей
                                                "SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
                                                "SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
                                                "SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
                                            ),
                                            false
                                        );?>
                                     <a href="#SITE_DIR#media/video/" class="btn btn-info btn-sm pull-right">Все видео</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <?endif;?>
                 <?if($themeConfig['main_page']['events'] === "Y"):?>
                 <div class="box" id="box-calendar-event">
                     <div class="box-title">
                         <h4>КАЛЕНДАРЬ СОБЫТИЙ</h4>
                     </div>
                     <div class="body-box box-out-padding">
                        <?$APPLICATION->IncludeFile(
                            SITE_DIR."/include/events_calendar.php",
                            Array(),
                            Array("MODE"=>"html")
                        );?> 
                     </div>
                 </div>
                 <?endif;?>
                 <?if($themeConfig['main_page']['banners'] === "Y"):?>
                 <?$APPLICATION->IncludeComponent("bitrix:news.list", "carusel_banners", Array(
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
                        "IBLOCK_ID" => "#BANNERS_IBLOCK_ID#",	// Код информационного блока
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
                    false
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
             <div class="col-sm-4 col-md-3">
                 <div id="box-about-main">
                     <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include", 
                        ".default", 
                        array(
                            "AREA_FILE_SHOW" => "sect",
                            "AREA_FILE_SUFFIX" => "profile",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "COMPONENT_TEMPLATE" => ".default",
                            "EDIT_TEMPLATE" => ""
                        ),
                        false
                    );?>
                    <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                        "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => "standard.php",
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH" => SITE_DIR."/include/head_box_main.php",
                            "OPTION_SITE" => $arOptionGosSite
                        ),
                        false,
                        array(
                        "HIDE_ICONS" => "Y"
                        )
                    );?> 
                    <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                        "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => "standard.php",
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH" => SITE_DIR."/include/about_box_main.php"
                        ),
                        false,
                        array(
                        "ACTIVE_COMPONENT" => "Y"
                        )
                    );?>
                 </div>
                 <div class="box" id="box-docs-main">
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
                                        "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                                        "IBLOCK_ID" => "#NPA_IBLOCK_ID#",
                                        "IBLOCK_TYPE" => "documents",
                                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                        "INCLUDE_SUBSECTIONS" => "N",
                                        "MESSAGE_404" => "",
                                        "NEWS_COUNT" => "4",
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
                                            2 => "",
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
                 <div id="box-img-link">
                    <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                        "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => "standard.php",
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH" => SITE_DIR."/include/vote_banner.php"
                        ),
                        false,
                        array(
                        "ACTIVE_COMPONENT" => "N"
                        )
                    );?>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include", 
                        ".default", 
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => "standard.php",
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH" => SITE_DIR."/include/internet_reception_banner.php",
                        ),
                        false
                    );?>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include", 
                        ".default", 
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => "standard.php",
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH" => SITE_DIR."/include/open_data_banner.php",
                        ),
                        false
                    );?> 
                 </div>
             </div>
         </div>
     </div>
 </div>
<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');?>