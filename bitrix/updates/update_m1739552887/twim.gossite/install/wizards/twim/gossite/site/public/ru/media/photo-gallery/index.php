<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Фотогалерея");
global $USER;
if ($USER->IsAdmin()){?>
    <p>
        <a href="#SITE_DIR#media/photo-gallery/upload/" class="btn btn-info">Загрузить фотографии</a>
    </p>
<?}
$APPLICATION->IncludeComponent(
	"bitrix:photo", 
	"gallery", 
	array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"DETAIL_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"IBLOCK_ID" => "#PHOTOS_IBLOCK_ID#",
		"IBLOCK_TYPE" => "media",
		"LIST_BROWSER_TITLE" => "-",
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "DETAIL_PICTURE",
			2 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Фотографии",
		"SECTION_COUNT" => "12",
		"SECTION_LINE_ELEMENT_COUNT" => "1",
		"SECTION_PAGE_ELEMENT_COUNT" => "24",
		"SECTION_SORT_FIELD" => "sort",
		"SECTION_SORT_ORDER" => "asc",
		"SEF_FOLDER" => "#SITE_DIR#media/photo-gallery/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"TOP_ELEMENT_COUNT" => "1",
		"TOP_ELEMENT_SORT_FIELD" => "sort",
		"TOP_ELEMENT_SORT_ORDER" => "asc",
		"TOP_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"TOP_LINE_ELEMENT_COUNT" => "1",
		"TOP_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"COMPONENT_TEMPLATE" => "gallery",
		"SEF_URL_TEMPLATES" => array(
			"sections_top" => "",
			"section" => "#SECTION_ID#/",
			"detail" => "#SECTION_ID#/#photo_#ELEMENT_ID#",
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
