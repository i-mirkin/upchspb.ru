<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
use Bitrix\Main\Application;
?>
<div class="row">
    <div class="col-sm-5 col-lg-4">
        <?if($arParams["USE_SEARCH"]=="Y"):?>
            <?$request = Application::getInstance()->getContext()->getRequest();
                $daterange = strip_tags(trim($request->getQuery("daterange")));  // daterange
                $q = $request->getQuery("q"); // set_filter
                if(isset($q) && !empty($daterange)){
                    $arDate = explode('-', $daterange);
                    function trim_date_string($n){return trim($n);} 
                    $arDate = array_map('trim_date_string', $arDate);
                    CheckFilterDates($arDate[0], $arDate[1], $date1_wrong, $date2_wrong, $date2_less);
                    if($date1_wrong != "Y" && $date2_wrong!="Y" && $date2_less!="Y"){
                        if(empty($q)){
                            $GLOBALS[$arParams["FILTER_NAME"]] = array(
                                ">=DATE_ACTIVE_FROM" => ConvertTimeStamp(strtotime($arDate[0]), "FULL"),
                                "<DATE_ACTIVE_FROM" => ConvertTimeStamp(strtotime($arDate[1] . '23:59:59'), "FULL")
                            );
                        } else {
                            $GLOBALS["arFilterSearch"] = array(
                                ">=DATE_FROM" => ConvertTimeStamp(strtotime($arDate[0]), "FULL"),
                                "<=DATE_FROM" => ConvertTimeStamp(strtotime($arDate[1] . '23:59:59'), "FULL")
                            );
                        }
                    }
                }
                $arElements = $APPLICATION->IncludeComponent(
                    "bitrix:search.page",
                    "",
                    Array(
                        "CHECK_DATES" => "Y",
                        "arrWHERE" => Array("iblock_".$arParams["IBLOCK_TYPE"]),
                        "arrFILTER" => Array("iblock_".$arParams["IBLOCK_TYPE"]),
                        "SHOW_WHEN" => "Y",
                        "FILTER_NAME" => "arFilterSearch",
                        //"PAGE_RESULT_COUNT" => "",
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "SET_TITLE" => $arParams["SET_TITLE"],
                        "arrFILTER_iblock_".$arParams["IBLOCK_TYPE"] => Array($arParams["IBLOCK_ID"])
                    ),
                    $component
                );
                if (!empty($arElements) && is_array($arElements))
                {
                    $GLOBALS[$arParams["FILTER_NAME"]]["=ID"] = $arElements; 
                }?>
        <?endif?>

        <div class="wrap-left-menu">
            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "",
                Array(
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "COMPONENT_TEMPLATE" => ".default",
                    "COUNT_ELEMENTS" => "Y",
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "PARENT_SECTION_CODE" => "",
                    "SECTION_FIELDS" => array(0=>"",1=>"",),
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "SECTION_USER_FIELDS" => array(0=>"",1=>"",),
                    "SHOW_PARENT_NAME" => "Y",
                    "TOP_DEPTH" => "1",
                    "VIEW_MODE" => "LINE"
                )
            );
            ?>            
        </div>
        <!--wrap-left-menu-->
    </div>
    <!--end col-->
    <div class="col-sm-7 col-lg-8">
        <?
        if (empty($arElements) && !empty($q)) {
            echo getMessage("CT_BCSE_NOT_FOUND");
        } else {

             $arItems = $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "",
                Array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "NEWS_COUNT" => $arParams["NEWS_COUNT"],
                    "SORT_BY1" => $arParams["SORT_BY1"],
                    "SORT_ORDER1" => $arParams["SORT_ORDER1"],
                    "SORT_BY2" => $arParams["SORT_BY2"],
                    "SORT_ORDER2" => $arParams["SORT_ORDER2"],
                    "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
                    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                    "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                    "MESSAGE_404" => $arParams["MESSAGE_404"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "SHOW_404" => $arParams["SHOW_404"],
                    "FILE_404" => $arParams["FILE_404"],
                    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
                    "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
                    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
                    "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
                    "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
                    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
                    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
                    "FILTER_NAME" => $arParams["FILTER_NAME"],
                    "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                    "CHECK_DATES" => $arParams["CHECK_DATES"],

                    "PARENT_SECTION" => $arResult["VARIABLES"]["SECTION_ID"],
                    "PARENT_SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
                ),
                $component
            );
            if(empty($arItems)){
                echo getMessage("CT_BCSE_NOT_ITEMS");
            }
        }
        ?>
    </div>
    <!--end col-->
</div>
<!--row-->
