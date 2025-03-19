<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("og:description", "Обращение");
$APPLICATION->SetPageProperty("og:title", "Обращение");
$APPLICATION->SetPageProperty("title", "Обращение");
$APPLICATION->SetPageProperty("keywords", "Обращение");
$APPLICATION->SetPageProperty("description", "Обращение");
$APPLICATION->SetTitle("Обращение");
global  $USER;
?><div class="ir-header">
	<div class="ir-header__menu">
		<ul class="ir-top-menu">
			<li class="ir-top-menu__item"> <a class="ir-top-menu__link" href="#SITE_DIR#appeals/internet-reception/"> <i class="fa fa-pencil ir-top-menu__icon"></i>
			Создать обращение </a> </li>
		</ul>
	</div>
</div>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.detail",
	"ir-detail-message",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_CODE" => "",
		"ELEMENT_ID" => $_REQUEST["id"],
		"FIELD_CODE" => array("CREATED_BY",""),
		"FILE_404" => "",
		"IBLOCK_ID" => "#INTERNET_RESEPTION_LIST_IBLOCK_ID#",
		"IBLOCK_TYPE" => "internet_reception",
		"IBLOCK_URL" => "",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Страница",
		"PROPERTY_CODE" => array("E_MAIL_AUTHOR","COMPANY_AUTHOR","PHONE_AUTHOR","THEME","STATUS","DATE","CATEGORY","AGENCY","COAUTHOR","FILE","ANSWER","MESSAGE"),
		"SET_BROWSER_TITLE" => "Y",
		"SET_CANONICAL_URL" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"STRICT_SECTION_CHECK" => "N",
		"USER_ID" => $USER->GetID(),
		"USE_PERMISSIONS" => "N",
		"USE_SHARE" => "N"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>