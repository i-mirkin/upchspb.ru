<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
global $USER;
$APPLICATION->SetTitle("Главная");
?><div class="col-left">
	 <? if (($themeConfig['main_page']["news"] == "list")) {
        $templateMainNews = "news_list";
    } else {
        $templateMainNews = "news_list_main";
    } ?>
	<div class="col-in col-in--crest">
		 <? global $arrFilterNewsMain;
        $arrFilterNewsMain = [];
        $arrFilterNewsMain['PROPERTY_THEME_STATUS'] = [44, 45];
        if (!$USER->IsAdmin()) {
            $arrFilterNewsMain['!PROPERTY_ADMIN_ONLY_VALUE'] = 'Y';
        }
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "news_list_main_item",
            array(
                "ACTIVE_DATE_FORMAT" => "d F Y",
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
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array(
                    0 => "DETAIL_TEXT",
                    1 => "",
                ),
                "FILE_404" => "",
                "FILTER_NAME" => "arrFilterNewsMain",
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
                    3 => "THEME_STATUS",
                    4 => "THEME_TIP",
                    5 => "THEME",
                    6 => "MAIN_NEWS",
                    7 => "BREAKING_NEWS",
                    8 => "TAG_LINK",
                    9 => "DATE",
                    10 => "MORE_PHOTOS",
                    11 => "",
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
                "COMPONENT_TEMPLATE" => "news_list_main_item",
                "STRICT_SECTION_CHECK" => "N"
            ),
            false
        ); ?> <?
        if (!$USER->IsAdmin()) {
            global $homeNewsFilter;
            $homeNewsFilter = [];
            $homeNewsFilter['!PROPERTY_ADMIN_ONLY_VALUE'] = 'Y';
        }
        ?> <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"news_list_main",
	Array(
		"ACTIVE_DATE_FORMAT" => "d F Y",
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
		"COMPONENT_TEMPLATE" => "news_list_main",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"DETAIL_TEXT",1=>"",),
		"FILE_404" => "",
		"FILTER_NAME" => "homeNewsFilter",
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
		"PROPERTY_CODE" => array(0=>"SOURCE",1=>"MAIN_SHOW",2=>"LINK_VIDEO",3=>"THEME_STATUS",4=>"THEME_TIP",5=>"THEME",6=>"MAIN_NEWS",7=>"BREAKING_NEWS",8=>"TAG_LINK",9=>"DATE",10=>"MORE_PHOTOS",11=>"",),
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
		"STRICT_SECTION_CHECK" => "N"
	)
);?>
	</div>
	 <? if ($themeConfig['main_page']['media'] === "Y"): ?> <?$APPLICATION->IncludeComponent(
	"bquadro:photo.sections.top",
	"albom_list_main",
	Array(
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "albom_list_main",
		"DETAIL_URL" => "",
		"ELEMENT_COUNT" => "1",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"FIELD_CODE" => array(0=>"",1=>"",),
		"FILTER_NAME" => "arrFilter",
		"IBLOCK_ID" => "6",
		"IBLOCK_TYPE" => "media",
		"LINE_ELEMENT_COUNT" => "1",
		"PROPERTY_CODE" => array(0=>"",1=>"",),
		"SECTION_COUNT" => "3",
		"SECTION_FIELDS" => array(0=>"",1=>"",),
		"SECTION_SORT_FIELD" => "sort",
		"SECTION_SORT_ORDER" => "asc",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(0=>"",1=>"",)
	)
);?> <? endif; ?> <?$APPLICATION->IncludeComponent(
	"bquadro:add.main",
	".default",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"box_title" => "История одного обращения",
		"prop_code" => "16,17,18, 34, 35, 36"
	)
);?> <? if ($IS_MAIN == 'Y' && $themeConfig['main_page']['slider'] === "Y"): ?> <? $APPLICATION->IncludeFile(
            SITE_DIR . "include/slider_main.php",
            array(),
            array("MODE" => "text")
        ); ?> <? endif; ?> <? if ($themeConfig['main_page']['banners'] === "Y"): ?> <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"partners",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
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
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"",1=>"",),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "21",
		"IBLOCK_TYPE" => "media",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"LINK",1=>"",),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC"
	)
);?> <? endif; ?> <? if ($themeConfig['main_page']['contacts'] === "Y"): ?>
	<div class="box">
		 <? $APPLICATION->IncludeFile(
                SITE_DIR . "/include/contacts_block.php",
                array("OPTION_SITE" => $arOptionGosSite),
                array("MODE" => "text", "SHOW_BORDER" => false)
            ); ?>
	</div>
	 <? endif; ?>
</div><? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>