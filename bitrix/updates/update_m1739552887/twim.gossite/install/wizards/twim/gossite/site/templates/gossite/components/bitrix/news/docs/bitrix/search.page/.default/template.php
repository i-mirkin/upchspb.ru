<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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
use Bitrix\Main\Application;
?>
<div class="search-page">
<form action="" method="get" class="form-filter-docs">
<div class="form-group form-group-sm">
    <?if($arParams["USE_SUGGEST"] === "Y"):
        if(strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"]))
        {
            $arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
            $obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
            $obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
        }
        ?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:search.suggest.input",
            "",
            array(
                "NAME" => "q",
                "VALUE" => $arResult["REQUEST"]["~QUERY"],
                "INPUT_SIZE" => 40,
                "DROPDOWN_SIZE" => 10,
                "FILTER_MD5" => $arResult["FILTER_MD5"],
            ),
            $component, array("HIDE_ICONS" => "Y")
        );?>
    <?else:?>
        <label for="text-serarch-doc"><?=getMessage("SEARCH")?></label>
        <input type="text" class="form-control" id="text-serarch-doc"name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>"  placeholder="<?=getMessage("BSF_T_SEARCH_PLACEHOLDER")?>">

    <?endif;?>
</div>
<?if($arParams["SHOW_WHEN"]):
    $request = Application::getInstance()->getContext()->getRequest();
    $daterange = strip_tags(trim($request->getQuery("daterange")));  // daterange
    ?>
    <label for="dates-docs"><?=getMessage("DESC_ALL_RANGE_DATE")?></label>
    <div class="row">
        <div class="col-sm-12">
             <div class="form-group form-group-sm">
                <input name="daterange" data-input="daterange" type="text" class="form-control" id="dates-docs" value="<?=$daterange?>">
            </div>
            <div class="clearfix">
                <div class="pull-right">
                    <button type="submit" class="btn btn-info"><?=GetMessage("SEARCH_GO")?></button>
                </div>
            </div>
        </div>
    </div>
<?else:?>
    <button type="submit" class="btn btn-info"><?=GetMessage("SEARCH_GO")?></button>
<?endif?>
</form>
</div>
<br>